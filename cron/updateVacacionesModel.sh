#!/bin/bash
psql -U postgres -d catic -f /var/www/html/catic/protected/models/updateVacaciones.sql
