#!/bin/sh
set -e

# Read the actual DNS nameserver from /etc/resolv.conf (Podman uses gateway IP)
RESOLVER=$(awk '/^nameserver/ {print $2; exit}' /etc/resolv.conf)
echo "▶ Nginx entrypoint — using resolver: ${RESOLVER}"

# Update the resolver in nginx config
sed -i "s/resolver 127\.0\.0\.11/resolver ${RESOLVER}/" /etc/nginx/conf.d/default.conf

echo "→ Starting nginx..."
exec nginx -g "daemon off;"
