#comande doctrine 

- vendor/bin/doctrine
- docker-compose exec slim  vendor/bin/doctrine orm:sc
hema-tool:create

- vendor/bin/doctrine orm:schema-tool:drop --force

- vendor/bin/doctrine orm:schema-tool:update --force --dump-sql
