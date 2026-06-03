#!/bin/sh
set -e

RESOLVER=$(awk '/^nameserver/ {print $2; exit}' /etc/resolv.conf)
echo "▶ Nginx entrypoint — using resolver: ${RESOLVER}"

# Copy config to /tmp to avoid modifying host bind-mount
cp /etc/nginx/conf.d/default.conf /tmp/default.conf
sed -i "s/resolver [^;]*/resolver ${RESOLVER} valid=30s ipv6=off/" /tmp/default.conf

echo "→ Starting nginx..."
exec nginx -c /tmp/default.conf -g "daemon off;"
