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

    # Backup original file
    cp "$PHP_FILE" "$PHP_FILE.backup"

    # Perform patches
    sed -i "s/'launcher.launcher'/'launcher.js'/g" "$PHP_FILE"
    sed -i 's/"launcher.launcher"/"launcher.js"/g' "$PHP_FILE"

    # Verify changes were made
    if grep -q "launcher.js" "$PHP_FILE"; then
      echo "Successfully patched vercel-php handler in $PHP_FILE"
    else
      echo "Warning: No launcher.js found in $PHP_FILE after patching"
      # Restore backup if patch didn't work as expected
      mv "$PHP_FILE.backup" "$PHP_FILE"
    fi
  fi
done

echo "Vercel-php patching completed"
