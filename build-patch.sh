#!/bin/bash
echo "Starting vercel-php patch..."
find /vercel/path0/.vercel/builders -name "index.js" -path "*vercel-php*" 2>/dev/null | while read PHP_FILE; do
  echo "Found builder at: $PHP_FILE"
  # Removed handler patch as 'launcher.launcher' is the correct AWS Lambda format
  
  # Also patch the launchers to fix LAMBDA_TASK_ROOT
  DIR_NAME=$(dirname "$PHP_FILE")
  echo "Patching launchers in $DIR_NAME/launchers/..."
  find "$DIR_NAME/launchers" -name "*.js" 2>/dev/null | while read LAUNCHER_FILE; do
    # Restore the export just in case it was cached from a previous bad patch
    if grep -q "module.exports = launcher;" "$LAUNCHER_FILE"; then
      sed -i "s/module.exports = launcher;/exports.launcher = launcher;/g" "$LAUNCHER_FILE" || true
      echo "Restored export in $LAUNCHER_FILE"
    fi

    # Fix LAMBDA_TASK_ROOT for Vercel Node 20+ runtime where it might be missing or incorrect
    if grep -q "process.env.LAMBDA_TASK_ROOT || '/'" "$LAUNCHER_FILE"; then
      sed -i "s/process.env.LAMBDA_TASK_ROOT || '\/'/__dirname/g" "$LAUNCHER_FILE" || true
      echo "Patched LAMBDA_TASK_ROOT in $LAUNCHER_FILE"
    fi
  done
done
echo "Finished vercel-php patch."
