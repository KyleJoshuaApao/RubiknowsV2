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

PATCH_FAILED=false

for PHP_FILE in $PHP_FILES; do
  if [ -n "$PHP_FILE" ] && [ -f "$PHP_FILE" ]; then
    echo "Processing $PHP_FILE"

    # Check if we can write to this file's directory (for backup)
    FILE_DIR=$(dirname "$PHP_FILE")
    if touch "$FILE_DIR/test_write_$$" 2>/dev/null; then
      # Writable filesystem - create backup
      rm -f "$FILE_DIR/test_write_$$"
      cp "$PHP_FILE" "$PHP_FILE.backup"
      BACKUP_AVAILABLE=true
    else
      # Read-only filesystem - skip backup
      echo "Warning: Read-only filesystem detected for $PHP_FILE, skipping backup"
      BACKUP_AVAILABLE=false
    fi

    # Perform patches
    sed -i "s/'launcher.launcher'/'launcher.js'/g" "$PHP_FILE"
    sed -i 's/"launcher.launcher"/"launcher.js"/g' "$PHP_FILE"

    # Verify changes were made
    if grep -q "launcher.js" "$PHP_FILE"; then
      echo "Successfully patched vercel-php handler in $PHP_FILE"
      # Clean up backup if we created one
      if [ "$BACKUP_AVAILABLE" = true ]; then
        rm -f "$PHP_FILE.backup"
      fi
    else
      echo "Error: Failed to patch $PHP_FILE - launcher.js not found after patching"
      PATCH_FAILED=true
      # Restore backup if we created one
      if [ "$BACKUP_AVAILABLE" = true ] && [ -f "$PHP_FILE.backup" ]; then
        mv "$PHP_FILE.backup" "$PHP_FILE"
        echo "Restored original file from backup"
      fi
    fi
  fi
done

if [ "$PATCH_FAILED" = true ]; then
  echo "One or more files failed to patch"
  exit 1
fi

echo "Vercel-php patching completed"
exit 0
