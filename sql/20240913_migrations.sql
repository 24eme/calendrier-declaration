DROP TABLE IF EXISTS failed_jobs;
DROP TABLE IF EXISTS password_resets;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS migrations;

ALTER TABLE evenements RENAME COLUMN title TO nom;
ALTER TABLE evenements RENAME COLUMN start TO date_debut;
ALTER TABLE evenements RENAME COLUMN end TO date_fin;
ALTER TABLE evenements RENAME COLUMN active TO actif;
ALTER TABLE evenements RENAME COLUMN rrule TO recurrence;
ALTER TABLE evenements RENAME COLUMN created_at TO date_creation;
ALTER TABLE evenements RENAME COLUMN updated_at TO date_modification;
ALTER TABLE evenements ADD COLUMN element_declencheur varchar;

ALTER TABLE familles DROP COLUMN slug;
ALTER TABLE familles DROP COLUMN couleur;

ALTER TABLE organismes DROP COLUMN slug;
ALTER TABLE organismes DROP COLUMN couleur;

ALTER TABLE tags DROP COLUMN slug;

ALTER TABLE types DROP COLUMN slug;
ALTER TABLE types DROP COLUMN color;
