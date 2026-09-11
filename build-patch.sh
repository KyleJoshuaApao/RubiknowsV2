#!/bin/bash
set -e
echo "Running vercel-php builder patch..."
PHP_FILE=$(find /vercel -name "index.js" -path "*vercel-php*" 2>/dev/null | head -1 || true)
if [ -n "$PHP_FILE" ] && [ -f "$PHP_FILE" ]; then
  sed -i "s/handler: 'launcher.launcher'/handler: 'launcher.js'/g" "$PHP_FILE"
  echo "Patched vercel-php handler in $PHP_FILE"
else
  echo "vercel-php builder not found, skipping patch"
fi
