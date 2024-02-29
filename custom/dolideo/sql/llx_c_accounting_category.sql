-- Copyright (C) 2024	Frédéric Hounkponou	<omegajunior.apps@gmail.com>
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

-- vider la table et ensuite recharger
TRUNCATE TABLE  llx_c_accounting_category;

-- Group of accounting accounts for report at the parish of Cotonou diocese - RECETTES
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  1, 'RECETTESPRINCIPALES',   'Rubrique regroupement des RECETTES PRINCIPALES',               '4xxxxx et 7xxxxx', 0, 0, '',                 '10', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  2, 'RECETTESPROPRESPAROISSIALES',  'Rubrique regroupement des RECETTES PROPRES PAROISSIALES',             '4xxxxx et 7xxxxx', 0, 0, '',                 '20', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  3, "RECETTESATRANSFERERALECONOMAT",  "Rubrique regroupement des RECETTES A TRANSFERER A L'ECONOMAT",             '4xxxxx et 7xxxxx', 0, 0, '',                 '30', 49, 1);

INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  4, 'TOTALDESRECETTESDEFONCTIONNEMENT',    'TOTAL DES RECETTES DE FONCTIONNEMENT',                                   '',                0, 1, 'RECETTESPRINCIPALES+RECETTESPROPRESPAROISSIALES+RECETTESATRANSFERERALECONOMAT', '40', 49, 1);

-- Group of accounting accounts for report at the parish of Cotonou diocese - DEPENSES
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  5, 'DEPENSESPRESBYTERE',   'Rubrique regroupement des DEPENSES PRESBYTERE',               '4xxxxx et 6xxxxx', 0, 0, '',                 '50', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  6, 'FOURNITURESENERGIES',  'Rubrique regroupement des DEPENSES FOURNITURES ENERGIES',             '4xxxxx et 6xxxxx', 0, 0, '',                 '60', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  7, "SECRETARIAT",  "Rubrique regroupement des DEPENSES SECRETARIAT",             '4xxxxx et 6xxxxx', 0, 0, '',                 '70', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  8, "MOYENSDEPLACEMENT",  "Rubrique regroupement des DEPENSES MOYENS DEPLACEMENT",             '4xxxxx et 6xxxxx', 0, 0, '',                 '80', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  9, "MOYENSEVANGELISATION",  "Rubrique regroupement des DEPENSES MOYENS EVANGELISATION",             '4xxxxx et 6xxxxx', 0, 0, '',                 '90', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  10, "CULTE",  "Rubrique regroupement des DEPENSES CULTE",             '4xxxxx et 6xxxxx', 0, 0, '',                 '100', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  11, "AUTRESDEPENSES",  "Rubrique regroupement des AUTRES DEPENSES",             '4xxxxx et 6xxxxx', 0, 0, '',                 '110', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  12, "IMPOTSTAXES",  "Rubrique regroupement des IMPOTS TAXES",             '4xxxxx et 6xxxxx', 0, 0, '',                 '120', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  13, "CHARGESPERSONNEL",  "Rubrique regroupement des CHARGES PERSONNEL",             '4xxxxx et 6xxxxx', 0, 0, '',                 '130', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  14, "RECETTESTRANSFERES",  "Rubrique regroupement des RECETTES TRANSFEREES",             '4xxxxx et 6xxxxx', 0, 0, '',                 '140', 49, 1);

INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  15, 'TOTALDESDEPENSESDEFONCTIONNEMENT',    'TOTAL DES DEPENSES DE FONCTIONNEMENT',                                   '',                0, 1, 'DEPENSESPRESBYTERE+FOURNITURESENERGIES+SECRETARIAT+MOYENSDEPLACEMENT+MOYENSEVANGELISATION+CULTE+AUTRESDEPENSES+IMPOTSTAXES+CHARGESPERSONNEL+RECETTESTRANSFERES', '150', 49, 1);


INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  16, "RESSOURCESINTERNES",  "Rubrique regroupement des RESSOURCES D''INVESTISSEMENTS INTERNES",             '2xxxxx', 0, 0, '',                 '160', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  17, "RESSOURCESEXTERNES",  "Rubrique regroupement des RESSOURCES D''INVESTISSEMENTS EXTERNES",             '2xxxxx ', 0, 0, '',                 '170', 49, 1);

INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  18, 'TOTALRESSOURCESINVESTISSEMENT',    'TOTAL DES RESSOURCES D''INVESTISSEMENT',                                   '',                0, 1, 'RESSOURCESINTERNES+RESSOURCESEXTERNES', '180', 49, 1);

INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  19, "CONSTRUCTIONS",  "Rubrique regroupement des DEPENSES DE CONSTRUCTIONS",             '2xxxxx', 0, 0, '',                 '190', 49, 1);
INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  20, "AUTRESIMMOBILISATIONS",  "Rubrique regroupement des DEPENSES AUTRES IMMOBILISATIONS",             '2xxxxx ', 0, 0, '',                 '200', 49, 1);

INSERT INTO llx_c_accounting_category (rowid, code, label, range_account, sens, category_type, formula, position, fk_country, active) VALUES (  21, 'TOTALDEPENSESINVESTISSEMENT',    'TOTAL DES DEPENSES D''INVESTISSEMENT',                                   '',                0, 1, 'CONSTRUCTIONS+AUTRESIMMOBILISATIONS', '210', 49, 1);
