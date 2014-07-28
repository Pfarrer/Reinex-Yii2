INSERT INTO contact_meta VALUES (NULL, 1, 'Winfried Pfretzschner', '3661-6285-14', '1723741104',
  NULL, NULL, NULL);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()), 'de', 'Geschäftsführer');

INSERT INTO contact_meta VALUES (NULL, 2, 'Sascha Lindner', '3661-6285-22', '1723741103',
	'konstruktion@reinex.de', 'reinex.konstruktion', NULL);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()), 'de', 'Konstruktion');

INSERT INTO contact_meta VALUES (NULL, 3, 'Bernhard Eckl', '3661-6285-13', '15774964636',
  'technik@reinex.de', NULL, NULL);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()), 'de', 'Technik');

INSERT INTO contact_meta VALUES (NULL, 4, 'Jörg Pfretzschner', '3661-6285-12', '1723741102',
  'verkauf@reinex.de', 'reinex.verkauf', NULL);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()),
	'de', 'Verkauf');

INSERT INTO contact_meta VALUES (NULL, 5, 'Tom Cramer', '3661-6285-16', NULL,
	'produktion@reinex.de', NULL, NULL);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()), 'de', 'Produktion');

INSERT INTO contact_meta VALUES (NULL, 6, 'Marina Bernhardt', '3661-6285-0', NULL,
	'verwaltung@reinex.de', NULL, NULL);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()), 'de', 'Verwaltung');
