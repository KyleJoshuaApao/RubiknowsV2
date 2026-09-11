#!/bin/bash
set -e
echo "Running vercel-php builder patch..."

# Check if /vercel directory exists
if [ ! -d "/vercel" ]; then
  echo "/vercel directory not found, skipping patch"
  exit 0
fi

# Find PHP files to patch
PHP_FILES=$(find /vercel -name "index.js" -path "*vercel-php*" 2>/dev/null || true)

if [ -z "$PHP_FILES" ]; then
  echo "No vercel-php index.js files found to patch"
  exit 0
fi

echo "Found $PHP_FILES to patch"

PATCHED_COUNT=0
FAILED_COUNT=0

for PHP_FILE in $PHP_FILES; do
  if [ -n "$PHP_FILE" ] && [ -f "$PHP_FILE" ]; then
    echo "Processing $PHP_FILE"

    # Check if we can write to this file's directory
    FILE_DIR=$(dirname "$PHP_FILE")
    if touch "$FILE_DIR/test_write_$$" 2>/dev/null; then
      # Writable filesystem
      rm -f "$FILE_DIR/test_write_$$"

      # Create backup if possible
      if cp "$PHP_FILE" "$PHP_FILE.backup" 2>/dev/null; then
        BACKUP_CREATED=true
      else
        echo "Warning: Could not create backup for $PHP_FILE"
        BACKUP_CREATED=false
      fi

      # Perform patches using sed -i
      if sed -i "s/'launcher.launcher'/'launcher.js'/g" "$PHP_FILE" && \
         sed -i 's/"launcher.launcher"/"launcher.js"/g' "$PHP_FILE"; then
        # Verify changes were made
        if grep -q "launcher.js" "$PHP_FILE"; then
          echo "Successfully patched vercel-php handler in $PHP_FILE"
          # Clean up backup
          rm -f "$PHP_FILE.backup"
          ((PATCHED_COUNT++))
        else
          echo "Error: Patch verification failed for $PHP_FILE"
          # Restore backup if we have it
          if [ "$BACKUP_CREATED" = true ] && [ -f "$PHP_FILE.backup" ]; then
            mv "$PHP_FILE.backup" "$PHP_FILE"
          fi
          ((FAILED_COUNT++))
        fi
      else
        echo "Error: Failed to apply patches to $PHP_FILE"
        # Restore backup if we have it
        if [ "$BACKUP_CREATED" = true ] && [ -f "$PHP_FILE.backup" ]; then
          mv "$PHP_FILE.backup" "$PHP_FILE"
        fi
        ((FAILED_COUNT++))
      fi
    else
      # Read-only filesystem - try alternative approach
      echo "Info: Read-only filesystem for $PHP_FILE, attempting alternative patching"

      # Create a temporary file in /tmp
      TEMP_FILE=$(mktemp /tmp/vercel-php-patch.XXXXXX) || {
        echo "Error: Could not create temporary file"
        ((FAILED_COUNT++))
        continue
      }

      # Copy the file to temp location, patch it, then try to copy back
      if cp "$PHP_FILE" "$TEMP_FILE" && \
         sed -i "s/'launcher.launcher'/'launcher.js'/g" "$TEMP_FILE" && \
         sed -i 's/"launcher.launcher"/"launcher.js"/g' "$TEMP_FILE" && \
         grep -q "launcher.js" "$TEMP_FILE"; then
        # Try to copy the patched file back
        if cp "$TEMP_FILE" "$PHP_FILE"; then
          echo "Successfully patched vercel-php handler in $PHP_FILE (read-only fs workaround)"
          ((PATCHED_COUNT++))
        else
          echo "Warning: Could not write patched file back to $PHP_FILE"
          ((FAILED_COUNT++))
        fi
      else
        echo "Error: Failed to patch temporary file for $PHP_FILE"
        ((FAILED_COUNT++))
      fi

      # Clean up temp file
      rm -f "$TEMP_FILE"
    fi
  fi
done

echo "Patch summary: $PATCHED_COUNT succeeded, $FAILED_COUNT failed"

if [ $PATCHED_COUNT -eq 0 ]; then
  echo "Error: No files were successfully patched"
  exit 1
fi

if [ $FAILED_COUNT -gt 0 ]; then
  echo "Warning: Some files failed to patch, but continuing since at least one succeeded"
fi

echo "Vercel-php patching completed"
exit 0
