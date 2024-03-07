-- ========================================================================
-- Copyright (C) 2023	Frédéric Hounkponou	<omegajunior.apps@gmail.com>
--
-- This program is free software; you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation; either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program. If not, see <https://www.gnu.org/licenses/>.
--
-- ========================================================================
-- Supprimez la table si elle existe déjà
-- DROP TABLE IF EXISTS llx_accounting_bookkeeping_extrafields;

-- Création de la table llx_csvh_services
CREATE TABLE IF NOT EXISTS llx_accounting_bookkeeping_extrafields
(
    rowid         integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
    tms           timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fk_object     integer NOT NULL,
    import_key    varchar(14)
) ENGINE=innodb;