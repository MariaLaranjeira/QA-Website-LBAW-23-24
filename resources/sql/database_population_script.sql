INSERT INTO users (name, username, email, password, profileURL) VALUES
('John Doe', 'johndoe123', 'johndoe@example.com', 'password123', 'https://example.com/johndoe'),
('Alice Smith', 'alicesmith', 'alice@example.com', 'alicepass', 'https://example.com/alicesmith'),
('Bob Johnson', 'bobjohnson', 'bob@example.com', 'bobpassword', 'https://example.com/bobjohnson'),
('Eva Johnson', 'evaj', 'eva@example.com', 'evapass', 'https://example.com/evajohnson'),
('Michael White', 'michaelw', 'michael@example.com', 'michaelpass', 'https://example.com/michaelwhite');

INSERT INTO moderator (mod_id) VALUES (1);

INSERT INTO admin (admin_id, email, password) VALUES (1, 'admin@example.com', 'adminpass');

INSERT INTO question (title, text_body, media_address, creation_date, rating, id_user) VALUES
('How to Build a Time Machine?', 'I am curious about time travel. Can anyone guide me on how to build a time machine?', NULL, CURRENT_TIMESTAMP, 10, 1),
('Is there life on Mars?', 'With all the advancements in space exploration, is there any evidence of life on Mars?', NULL, CURRENT_TIMESTAMP, 15, 2),
('What is the future of artificial intelligence?', 'I am interested in the future of AI. What advancements can we expect in the next decade?', NULL, CURRENT_TIMESTAMP, 18, 4),
('How does quantum computing work?', 'I have heard about quantum computing, but I don’t understand how it works. Can someone explain?', NULL, CURRENT_TIMESTAMP, 22, 5);

INSERT INTO answer (text_body, rating, media_address, creation_date, id_user, id_question) VALUES
('Building a time machine is currently theoretical. Scientists are exploring the concept through theories like wormholes and relativity.', 8, NULL, CURRENT_TIMESTAMP, 2, 1),
('While there is no direct evidence of life on Mars, scientists have found signs that suggest the possibility of microbial life in the past.', 12, NULL, CURRENT_TIMESTAMP, 3, 2),
('The future of AI is exciting! We can expect improvements in natural language processing, computer vision, and AI-driven healthcare technologies.', 15, NULL, CURRENT_TIMESTAMP, 2, 3),
('Quantum computing utilizes qubits and superposition to perform complex calculations. It has the potential to revolutionize cryptography and solve problems currently infeasible for classical computers.', 20, NULL, CURRENT_TIMESTAMP, 3, 4);


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
