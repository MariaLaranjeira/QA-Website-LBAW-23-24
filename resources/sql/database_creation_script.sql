DROP SCHEMA IF EXISTS lbaw2336 CASCADE;
CREATE SCHEMA IF NOT EXISTS lbaw2336;
SET search_path TO lbaw2336;


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
  picture TEXT DEFAULT 'default.jpg' NOT NULL,
  is_admin BOOLEAN DEFAULT False,
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
  media_address TEXT DEFAULT 'default.jpg' NOT NULL,
  creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  rating INTEGER NOT NULL DEFAULT 0,
  id_user INTEGER NOT NULL,
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE
);

CREATE TABLE answer (
  answer_id SERIAL PRIMARY KEY,
  text_body TEXT NOT NULL,
  rating INTEGER NOT NULL DEFAULT 0,
  media_address TEXT DEFAULT 'default.jpg' NOT NULL,
  creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_user INTEGER NOT NULL,
  id_question INTEGER NOT NULL,
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_question) REFERENCES question(question_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE tag (
  name TEXT PRIMARY KEY
);

CREATE TABLE question_tag (
  id_question INTEGER NOT NULL,
  id_tag TEXT NOT NULL,
  PRIMARY KEY (id_question, id_tag),
  FOREIGN KEY (id_question) REFERENCES question(question_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (id_tag) REFERENCES tag(name) ON UPDATE CASCADE ON DELETE CASCADE
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
  FOREIGN KEY (id_question) REFERENCES question(question_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (id_answer) REFERENCES answer(answer_id) ON UPDATE CASCADE ON DELETE CASCADE,
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
  FOREIGN KEY (id_question) REFERENCES question(question_id) ON UPDATE CASCADE ON DELETE CASCADE,
  CHECK (rating = 0 OR rating = 1)
);

CREATE TABLE user_rating_answer (
  id_user INTEGER NOT NULL,
  id_answer INTEGER NOT NULL,
  rating INTEGER NOT NULL,
  PRIMARY KEY (id_user, id_answer),
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_answer) REFERENCES answer(answer_id) ON UPDATE CASCADE ON DELETE CASCADE,
  CHECK (rating = 0 OR rating = 1)
);

CREATE TABLE user_follow_tag (
  id_user INTEGER NOT NULL,
  id_tag TEXT NOT NULL,
  PRIMARY KEY (id_user, id_tag),
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_tag) REFERENCES tag(name) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE user_follow_question (
  id_user INTEGER NOT NULL,
  id_question INTEGER NOT NULL,
  PRIMARY KEY (id_user, id_question),
  FOREIGN KEY (id_user) REFERENCES users(user_id) ON UPDATE CASCADE,
  FOREIGN KEY (id_question) REFERENCES question(question_id) ON UPDATE CASCADE ON DELETE CASCADE
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

--Populate

INSERT INTO users (name, username, email, password, profileURL) VALUES
('John Doe', 'johndoe123', 'johndoe@example.com', '$2y$10$b5meAPjLa0.o2m.Jzf3Z1upaVTLytyL1Xy2aw/lotptbCNznMdmsS', 'https://example.com/johndoe'),
('Alice Smith', 'alicesmith', 'alice@example.com', 'alicepass', 'https://example.com/alicesmith'),
('Bob Johnson', 'bobjohnson', 'bob@example.com', 'bobpassword', 'https://example.com/bobjohnson'),
('Eva Johnson', 'evaj', 'eva@example.com', 'evapass', 'https://example.com/evajohnson'),
('Michael White', 'michaelw', 'michael@example.com', 'michaelpass', 'https://example.com/michaelwhite');

--ADMIN
INSERT INTO users (name, username, email, password, is_admin, profileURL) VALUES
('John Admin', 'Admin', 'admin@example.com', '$2y$10$w7tQcOPURHIL3OaRyGRy1OUHAlPcjr.P1AyQr2L9n3hJ5wITbbifi','True', 'https://example.com/admin'); 
--pass is 12345678



INSERT INTO moderator (mod_id) VALUES (1);

INSERT INTO admin (admin_id, email, password) VALUES (1, 'admin@example.com', 'adminpass');

INSERT INTO question (title, text_body, media_address, creation_date, rating, id_user) VALUES
('How to Build a Time Machine?', 'I am curious about time travel. Can anyone guide me on how to build a time machine?', 'default.jpg', CURRENT_TIMESTAMP, 10, 1),
('Is there life on Mars?', 'With all the advancements in space exploration, is there any evidence of life on Mars?', 'default.jpg', CURRENT_TIMESTAMP, 15, 2),
('What is the future of artificial intelligence?', 'I am interested in the future of AI. What advancements can we expect in the next decade?', 'default.jpg', CURRENT_TIMESTAMP, 18, 4),
('How does quantum computing work?', 'I have heard about quantum computing, but I don’t understand how it works. Can someone explain?', 'default.jpg', CURRENT_TIMESTAMP, 22, 5);

INSERT INTO answer (text_body, rating, media_address, creation_date, id_user, id_question) VALUES
('Building a time machine is currently theoretical. Scientists are exploring the concept through theories like wormholes and relativity.', 8, 'default.jpg', CURRENT_TIMESTAMP, 2, 1),
('While there is no direct evidence of life on Mars, scientists have found signs that suggest the possibility of microbial life in the past.', 12, 'default.jpg', CURRENT_TIMESTAMP, 3, 2),
('The future of AI is exciting! We can expect improvements in natural language processing, computer vision, and AI-driven healthcare technologies.', 15, 'default.jpg', CURRENT_TIMESTAMP, 2, 3),
('Quantum computing utilizes qubits and superposition to perform complex calculations. It has the potential to revolutionize cryptography and solve problems currently infeasible for classical computers.', 20, 'default.jpg', CURRENT_TIMESTAMP, 3, 4);


INSERT INTO tag (name) VALUES
('Time Travel'),
('Space Exploration'),
('Artificial Intelligence'),
('Quantum Computing');

INSERT INTO question_tag (id_question, id_tag) VALUES
(1, 'Time Travel'),
(2, 'Space Exploration'),
(3, 'Artificial Intelligence'),
(4, 'Quantum Computing');

INSERT INTO comment (text_body, creation_date, id_user, id_question, id_answer, comment_type) VALUES
('Interesting question! I also wonder about time travel and its possibilities.', CURRENT_TIMESTAMP, 2, 1, NULL, 'QuestionComment'),
('I think space agencies are actively looking for signs of life on Mars. Exciting times for space exploration!', CURRENT_TIMESTAMP, 3, 2, NULL, 'QuestionComment'),
('I am also curious about the future of AI. I think we will see a lot of advancements in the next decade.', CURRENT_TIMESTAMP, 5, 3, NULL, 'QuestionComment'),
('Quantum computing is a fascinating topic. I think it will be a while before we see practical applications of it.', CURRENT_TIMESTAMP, 4, 4, NULL, 'QuestionComment'),
('I think time travel is possible through wormholes. However, we do not have the technology to build a time machine yet.', CURRENT_TIMESTAMP, 1, NULL, 1, 'AnswerComment'),
('I think we will find evidence of life on Mars in the next decade. I am excited to see what we discover!', CURRENT_TIMESTAMP, 2, NULL, 2, 'AnswerComment'),
('I think AI will be used in many industries, including healthcare, finance, and transportation.', CURRENT_TIMESTAMP, 3, NULL, 3, 'AnswerComment'),
('Quantum computing is a fascinating topic. I think it will be a while before we see practical applications of it.', CURRENT_TIMESTAMP, 4, NULL, 4, 'AnswerComment');

INSERT INTO user_rating_question (id_user, id_question, rating) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 0),
(4, 2, 1),
(5, 3, 0);

INSERT INTO user_rating_answer (id_user, id_answer, rating) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 0),
(4, 4, 0),
(5, 1, 1);

INSERT INTO user_follow_tag (id_user, id_tag)
VALUES
(1, 'Time Travel'),
(1, 'Space Exploration'),
(2, 'Time Travel'),
(3, 'Artificial Intelligence'),
(4, 'Space Exploration'),
(4, 'Artificial Intelligence');

INSERT INTO user_follow_question (id_user, id_question)
VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(4, 4);
