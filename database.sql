create table users(
  id integer primary key autoincrement,
  name text,
  password text
  );

insert into users (name, password) values ("user1", "test");
insert into users (name, password) values ("user2", "test2");

create table threads(
  id integer primary key autoincrement,
  name text
);

insert into threads (name) values ("テスト");

create table responses(
  id integer primary key autoincrement,
  thread_id integer ,
  content text
);

insert into responses (thread_id, content) values (1, "書いてけ");