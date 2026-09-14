#!/bin/bash
echo "Starting vercel-php patch..."
find /vercel/path0/.vercel/builders -name "index.js" -path "*vercel-php*" 2>/dev/null | while read PHP_FILE; do
  echo "Found builder at: $PHP_FILE"
  if grep -q "handler: 'launcher.launcher'" "$PHP_FILE"; then
    echo "String 'handler: launcher.launcher' found! Patching index.js..."
    sed -i "s/handler: 'launcher.launcher'/handler: 'launcher.js'/g" "$PHP_FILE" || true
    echo "Patch applied."
  fi
  
  # Also patch the launchers to use default export and fix LAMBDA_TASK_ROOT
  DIR_NAME=$(dirname "$PHP_FILE")
  echo "Patching launchers in $DIR_NAME/launchers/..."
  find "$DIR_NAME/launchers" -name "*.js" 2>/dev/null | while read LAUNCHER_FILE; do
    if grep -q "exports.launcher = launcher;" "$LAUNCHER_FILE"; then
      sed -i "s/exports.launcher = launcher;/module.exports = launcher;/g" "$LAUNCHER_FILE" || true
      echo "Patched export in $LAUNCHER_FILE"
    fi
    if grep -q "process.env.LAMBDA_TASK_ROOT || '/'" "$LAUNCHER_FILE"; then
      sed -i "s/process.env.LAMBDA_TASK_ROOT || '\/'/__dirname/g" "$LAUNCHER_FILE" || true
      echo "Patched LAMBDA_TASK_ROOT in $LAUNCHER_FILE"
    fi
  done
done
echo "Finished vercel-php patch."
