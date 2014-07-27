INSERT INTO contact_meta VALUES (NULL, 1);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()),
	'de', 'Winfried Pfretzschner', 'Geschäftsführer',
	'3661-6285-14', '1723741104'
	, NULL, NULL, NULL);

INSERT INTO contact_meta VALUES (NULL, 2);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()),
	'de', 'Sascha Lindner', 'Konstruktion',
	'3661-6285-22', '1723741103',
	'konstruktion@reinex.de', 'reinex.konstruktion', NULL);

INSERT INTO contact_meta VALUES (NULL, 3);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()), 'de', 'Bernhard Eckl', 'Technik',
	'3661-6285-13', '15774964636',
	'technik@reinex.de', NULL, NULL);

INSERT INTO contact_meta VALUES (NULL, 4);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()),
	'de', 'Jörg Pfretzschner', 'Verkauf',
	'3661-6285-12', '1723741102',
	'verkauf@reinex.de', 'reinex.verkauf', NULL);

INSERT INTO contact_meta VALUES (NULL, 5);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()), 'de', 'Tom Cramer', 'Produktion',
	'3661-6285-16', NULL,
	'produktion@reinex.de', NULL, NULL);

INSERT INTO contact_meta VALUES (NULL, 6);
INSERT INTO contact_i18n VALUES
	((SELECT LAST_INSERT_ID()), 'de', 'Marina Bernhardt', 'Verwaltung',
	'3661-6285-0', NULL,
	'verwaltung@reinex.de', NULL, NULL);
