-- ========================================================================
-- Copyright (C) 2018-2021  Philippe GRAND 	<philippe.grand@atoo-net.com>
--
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program.  If not, see http://www.gnu.org/licenses/.


CREATE TABLE llx_c_ultimateimmo_immoproperty_type(
	-- BEGIN MODULEBUILDER FIELDS
	rowid integer AUTO_INCREMENT PRIMARY KEY NOT NULL, 
	code varchar(50) NOT NULL,
	entity integer DEFAULT 1 NOT NULL,
	label varchar(255),   
	active  tinyint DEFAULT 1  NOT NULL,
	module  varchar(32) NULL
	-- END MODULEBUILDER FIELDS
) ENGINE=innodb;