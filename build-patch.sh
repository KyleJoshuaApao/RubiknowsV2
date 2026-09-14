#!/bin/bash
echo "Starting vercel-php patch..."
PHP_FILE=$(find /vercel -name "index.js" -path "*/vercel-php/dist/index.js" 2>/dev/null | head -1)

if [ -n "$PHP_FILE" ]; then
  echo "Found builder at: $PHP_FILE"
  if grep -q "handler: 'launcher.launcher'" "$PHP_FILE"; then
    echo "String 'handler: launcher.launcher' found! Patching index.js..."
    sed -i "s/handler: 'launcher.launcher'/handler: 'launcher.js'/g" "$PHP_FILE" || true
    echo "Patch applied."
  fi
  
  # Fix LAMBDA_TASK_ROOT for Vercel Node 20+ runtime in launchers
  DIR_NAME=$(dirname "$PHP_FILE")
  echo "Patching LAMBDA_TASK_ROOT in launchers in $DIR_NAME/launchers/..."
  find "$DIR_NAME/launchers" -name "*.js" 2>/dev/null | while read LAUNCHER_FILE; do
    if grep -q "process.env.LAMBDA_TASK_ROOT || '/'" "$LAUNCHER_FILE"; then
      sed -i "s/process.env.LAMBDA_TASK_ROOT || '\/'/__dirname/g" "$LAUNCHER_FILE" || true
      echo "Patched LAMBDA_TASK_ROOT in $LAUNCHER_FILE"
    fi
  done
else
  echo "Could not find vercel-php builder to patch."
fi
echo "Finished vercel-php patch."
