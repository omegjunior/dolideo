-- Copyright (C) 2023	Frédéric Hounkponou	<omegajunior.apps@gmail.com>
--
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

--
-- Do not put a comment at the end of the line, this file is parsed during the
-- install and all '--' symbols are removed.
--
-- Ne pas placer de commentaire en fin de ligne, ce fichier est parsé lors
-- de l'install et tous les sigles '--' sont supprimés.

INSERT INTO llx_secretariatmesse_recurrence (label, status, entity, fk_user_creat, fk_user_modif, date_creation)
VALUES
    ('Unique', 1, __ENTITY__, 1, 1, NOW()),
    ('Triduum', 1, __ENTITY__, 1, 1, NOW()),
    ('Septenaire', 1, __ENTITY__, 1, 1, NOW()),
    ('Neuvaine', 1, __ENTITY__, 1, 1, NOW()),
    ('Trentin', 1, __ENTITY__, 1, 1, NOW());