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

for PHP_FILE in $PHP_FILES; do
  if [ -n "$PHP_FILE" ] && [ -f "$PHP_FILE" ]; then
    echo "Processing $PHP_FILE"

    # Check if filesystem is writable by attempting to create a temporary file
    if touch "$PHP_FILE.testwrite" 2>/dev/null; then
      # Filesystem is writable, create backup
      rm -f "$PHP_FILE.testwrite"
      cp "$PHP_FILE" "$PHP_FILE.backup"
      BACKUP_CREATED=true
    else
      # Filesystem is read-only, skip backup
      echo "Warning: Filesystem is read-only, skipping backup for $PHP_FILE"
      BACKUP_CREATED=false
    fi

    # Perform patches
    sed -i "s/'launcher.launcher'/'launcher.js'/g" "$PHP_FILE"
    sed -i 's/"launcher.launcher"/"launcher.js"/g' "$PHP_FILE"

    # Verify changes were made
    if grep -q "launcher.js" "$PHP_FILE"; then
      echo "Successfully patched vercel-php handler in $PHP_FILE"
      # Clean up backup if we created one
      if [ "$BACKUP_CREATED" = true ]; then
        rm -f "$PHP_FILE.backup"
      fi
    else
      echo "Error: Failed to patch $PHP_FILE"
      # Restore backup if we created one
      if [ "$BACKUP_CREATED" = true ] && [ -f "$PHP_FILE.backup" ]; then
        mv "$PHP_FILE.backup" "$PHP_FILE"
        echo "Restored original file from backup"
      fi
      exit 1
    fi
  fi
done

echo "Vercel-php patching completed"
