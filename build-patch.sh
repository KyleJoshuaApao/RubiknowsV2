#!/bin/bash
set -e
echo "Running vercel-php builder patch..."
PHP_FILES=$(find /vercel -name "index.js" -path "*vercel-php*" 2>/dev/null || true)
for PHP_FILE in $PHP_FILES; do
  if [ -n "$PHP_FILE" ] && [ -f "$PHP_FILE" ]; then
    sed -i "s/'launcher.launcher'/'launcher.js'/g" "$PHP_FILE"
    sed -i 's/"launcher.launcher"/"launcher.js"/g' "$PHP_FILE"
    echo "Patched vercel-php handler in $PHP_FILE"
  fi
done
