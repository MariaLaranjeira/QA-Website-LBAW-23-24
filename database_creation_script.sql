DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS question_tag CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS answer CASCADE;
DROP TABLE IF EXISTS question CASCADE;
DROP TABLE IF EXISTS admin CASCADE;
DROP TABLE IF EXISTS moderator CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS user_rating_question CASCADE;
DROP TABLE IF EXISTS user_rating_answer CASCADE;
DROP TABLE IF EXISTS user_follow_tag CASCADE;
DROP TABLE IF EXISTS user_follow_question CASCADE;
DROP TYPE IF EXISTS comment_type CASCADE;
DROP FUNCTION IF EXISTS user_tsvector CASCADE;
DROP FUNCTION IF EXISTS question_tsvector CASCADE;
DROP FUNCTION IF EXISTS comment_tsvector CASCADE;
DROP FUNCTION IF EXISTS answer_tsvector CASCADE;
DROP FUNCTION IF EXISTS tag_tsvector CASCADE;
DROP FUNCTION IF EXISTS check_answer_user CASCADE;
DROP FUNCTION IF EXISTS check_comment_user CASCADE;
DROP FUNCTION IF EXISTS check_question_rating CASCADE;
DROP FUNCTION IF EXISTS check_answer_rating CASCADE;
DROP TRIGGER IF EXISTS user_tsvector ON users CASCADE;
DROP TRIGGER IF EXISTS question_tsvector ON question CASCADE;
DROP TRIGGER IF EXISTS comment_tsvector ON comment CASCADE;
DROP TRIGGER IF EXISTS answer_tsvector ON answer CASCADE;
DROP TRIGGER IF EXISTS tag_tsvector ON tag CASCADE;
DROP TRIGGER IF EXISTS trg_check_answer_user ON answer CASCADE;
DROP TRIGGER IF EXISTS trg_check_comment_user ON comment CASCADE;
DROP TRIGGER IF EXISTS trg_check_question_rating ON question CASCADE;
DROP TRIGGER IF EXISTS trg_check_answer_rating ON answer CASCADE;
DROP INDEX IF EXISTS creation_date_index_question CASCADE;
DROP INDEX IF EXISTS creation_date_index_answer CASCADE;
DROP INDEX IF EXISTS created_questions_index CASCADE;
DROP INDEX IF EXISTS user_tsvector_index CASCADE;
DROP INDEX IF EXISTS question_tsvector_index CASCADE;
DROP INDEX IF EXISTS comment_tsvector_index CASCADE;
DROP INDEX IF EXISTS answer_tsvector_index CASCADE;
DROP INDEX IF EXISTS tag_tsvector_index CASCADE;



CREATE TYPE comment_type AS ENUM ('QuestionComment', 'AnswerComment');

CREATE TABLE users (
  user_id SERIAL PRIMARY KEY,
  name TEXT NOT NULL,
  username TEXT UNIQUE NOT NULL,
  email TEXT UNIQUE NOT NULL,
  password TEXT NOT NULL,
  profileURL TEXT
);

CREATE TABLE moderator (
  mod_id INTEGER PRIMARY KEY,
  FOREIGN KEY (mod_id) REFERENCES users(user_id) ON UPDATE CASCADE
);

CREATE TABLE admin (
  admin_id SERIAL PRIMARY KEY,
  email TEXT UNIQUE NOT NULL,
  password TEXT NOT NULL
);

CREATE TABLE question (
  question_id SERIAL PRIMARY KEY,
  title TEXT NOT NULL,
  text_body TEXT NOT NULL,
  media_address TEXT,
  creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  rating INTEGER NOT NULL DEFAULT 0,
  id_user INTEGER NOT NULL,
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE
);

CREATE TABLE answer (
  answer_id SERIAL PRIMARY KEY,
  text_body TEXT NOT NULL,
  rating INTEGER NOT NULL DEFAULT 0,
  media_address TEXT,
  creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_user INTEGER NOT NULL,
  id_question INTEGER NOT NULL,
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_question) REFERENCES question(question_id) ON UPDATE CASCADE
);

CREATE TABLE tag (
  name TEXT PRIMARY KEY
);

CREATE TABLE question_tag (
  id_question INTEGER NOT NULL,
  id_tag TEXT NOT NULL,
  PRIMARY KEY (id_question, id_tag),
  FOREIGN KEY (id_question) REFERENCES question(question_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_tag) REFERENCES tag(name) ON UPDATE CASCADE
);

CREATE TABLE comment (
  comment_id SERIAL PRIMARY KEY,
  text_body TEXT NOT NULL,
  creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_user INTEGER NOT NULL,
  id_question INTEGER,
  id_answer INTEGER,
  comment_type comment_type NOT NULL,
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_question) REFERENCES question(question_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_answer) REFERENCES answer(answer_id) ON UPDATE CASCADE,
  CHECK (
    (comment_type = 'QuestionComment' AND id_question IS NOT NULL AND id_answer IS NULL) OR
    (comment_type = 'AnswerComment' AND id_question IS NULL AND id_answer IS NOT NULL)
  )
);

CREATE TABLE user_rating_question (
  id_user INTEGER NOT NULL,
  id_question INTEGER NOT NULL,
  rating INTEGER NOT NULL,
  PRIMARY KEY (id_user, id_question),
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_question) REFERENCES question(question_id) ON UPDATE CASCADE,
  CHECK (rating = 0 OR rating = 1)
);

CREATE TABLE user_rating_answer (
  id_user INTEGER NOT NULL,
  id_answer INTEGER NOT NULL,
  rating INTEGER NOT NULL,
  PRIMARY KEY (id_user, id_answer),
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_answer) REFERENCES answer(answer_id) ON UPDATE CASCADE,
  CHECK (rating = 0 OR rating = 1)
);

CREATE TABLE user_follow_tag (
  id_user INTEGER NOT NULL,
  id_tag TEXT NOT NULL,
  PRIMARY KEY (id_user, id_tag),
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_tag) REFERENCES tag(name) ON UPDATE CASCADE
);

CREATE TABLE user_follow_question (
  id_user INTEGER NOT NULL,
  id_question INTEGER NOT NULL,
  PRIMARY KEY (id_user, id_question),
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_question) REFERENCES question(question_id) ON UPDATE CASCADE
);

--Index01

CREATE INDEX creation_date_index_question ON question USING btree(creation_date);
CLUSTER question USING creation_date_index_question;

--Index02

CREATE INDEX creation_date_index_answer ON answer USING btree(creation_date);
CLUSTER answer USING creation_date_index_answer;

--Index03

CREATE INDEX created_questions_index ON question USING hash(id_user);

--Index04

CREATE INDEX user_tsvector_index ON users USING GIN(to_tsvector('english', name || ' ' || username || ' ' || email));

--Index05

CREATE INDEX question_tsvector_index ON question USING GIN(to_tsvector('english', title || ' ' || text_body));

--Index06

CREATE INDEX comment_tsvector_index ON comment USING GIN(to_tsvector('english', text_body));

--Index07

CREATE INDEX answer_tsvector_index ON answer USING GIST(to_tsvector('english', text_body));

--Index08

CREATE INDEX tag_tsvector_index ON tag USING GIN(to_tsvector('english', name));




--Trigger06

CREATE FUNCTION check_answer_user()
RETURNS trigger AS $$
BEGIN
    IF NEW.id_user = (SELECT id_user FROM question WHERE question_id = NEW.id_question) THEN
        RAISE EXCEPTION 'A user cannot answer their own questions';
    END IF;
    RETURN NEW;
END; 

$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_check_answer_user
BEFORE INSERT ON answer
FOR EACH ROW
EXECUTE PROCEDURE check_answer_user();

--Trigger07

CREATE FUNCTION check_comment_user()
RETURNS trigger AS $$
BEGIN
    IF NEW.id_user = (SELECT id_user FROM answer WHERE answer_id = NEW.id_answer) THEN
        RAISE EXCEPTION 'A user cannot comment on their own answers';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_check_comment_user
BEFORE INSERT ON comment
FOR EACH ROW
EXECUTE PROCEDURE check_comment_user();

--Trigger08

CREATE FUNCTION check_question_rating()
RETURNS trigger AS $$
BEGIN
    IF EXISTS (SELECT * FROM user_rating_question WHERE id_user = NEW.id_user AND id_question = NEW.id_question) THEN
        RAISE EXCEPTION 'A user cannot rate a question more than once';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_check_question_rating
BEFORE INSERT ON user_rating_question
FOR EACH ROW
EXECUTE PROCEDURE check_question_rating();

--Trigger09

CREATE FUNCTION check_answer_rating()
RETURNS trigger AS $$
BEGIN
    IF EXISTS (SELECT * FROM user_rating_answer WHERE id_user = NEW.id_user AND id_answer = NEW.id_answer) THEN
        RAISE EXCEPTION 'A user cannot rate an answer more than once';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_check_answer_rating
BEFORE INSERT ON user_rating_answer
FOR EACH ROW
EXECUTE PROCEDURE check_answer_rating();
