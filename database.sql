DROP TABLE IF EXISTS backlog_items;
DROP TABLE IF EXISTS backlog_tasks;
DROP TABLE IF EXISTS board_columns;
DROP TABLE IF EXISTS boards;
DROP TABLE IF EXISTS backlogs;
DROP TABLE IF EXISTS projects;

CREATE TABLE projects(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title text NOT NULL
);

CREATE TABLE backlogs(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title text NOT NULL,
	project_id int NOT NULL,
	FOREIGN KEY (project_id) REFERENCES projects (id)
);

CREATE TABLE boards(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title text NOT NULL,
	backlog_id int NOT NULL,
	column_done int NOT NULL,
	FOREIGN KEY (backlog_id) REFERENCES backlogs (id)
);

CREATE TABLE board_columns(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title text NOT NULL,
	arranged_order int NOT NULL,
	board_id int NOT NULL,
	FOREIGN KEY (board_id) REFERENCES boards (id)
);

CREATE TABLE backlog_tasks(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title text NOT NULL,
	details text,
	prio int,
	backlog_id int NOT NULL,
	column_id int,
	is_done boolean,
	FOREIGN KEY (backlog_id) REFERENCES backlogs (id),
	FOREIGN KEY (column_id) REFERENCES board_columns (id)
);

CREATE TABLE backlog_items(
	id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title text NOT NULL,
	details text,
	prio int,
	task_id int NOT NULL,
	column_id int,
	FOREIGN KEY (task_id) REFERENCES backlog_tasks (id),
	FOREIGN KEY (column_id) REFERENCES board_columns (id)
);


/* Data */

INSERT INTO projects (title) VALUES ('project');
INSERT INTO backlogs (title, project_id) VALUES ('backlog', 1);
INSERT INTO boards (title, backlog_id, column_done) VALUES ('board', 1, 4);
INSERT INTO board_columns (title, arranged_order, board_id) VALUES ('todo', 1, 1);
INSERT INTO board_columns (title, arranged_order, board_id) VALUES ('started', 2, 1);
INSERT INTO board_columns (title, arranged_order, board_id) VALUES ('test', 3, 1);
INSERT INTO board_columns (title, arranged_order, board_id) VALUES ('done', 4, 1);

