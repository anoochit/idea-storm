CREATE TABLE member (
  memid BIGINT  NOT NULL   AUTO_INCREMENT,
  fname VARCHAR(80)  NOT NULL  ,
  email VARCHAR(50)  NOT NULL  ,
  openid VARCHAR(100)  NOT NULL  ,
  date DATETIME  NOT NULL  ,
  priv ENUM('a','u')  NOT NULL DEFAULT 'u'   ,
PRIMARY KEY(memid));



CREATE TABLE category (
  catid BIGINT  NOT NULL   AUTO_INCREMENT,
  title VARCHAR(200)  NOT NULL  ,
  body TEXT  NOT NULL  ,
  date DATETIME  NOT NULL    ,
PRIMARY KEY(catid));



CREATE TABLE node (
  nid BIGINT  NOT NULL   AUTO_INCREMENT,
  catid BIGINT  NOT NULL  ,
  memid BIGINT  NOT NULL  ,
  title VARCHAR(200)  NOT NULL  ,
  body TEXT  NOT NULL  ,
  date DATETIME  NOT NULL  ,
  score BIGINT  NOT NULL DEFAULT 1   ,
PRIMARY KEY(nid)  ,
INDEX node_FKIndex1(memid)  ,
INDEX node_FKIndex2(catid),
  FOREIGN KEY(memid)
    REFERENCES member(memid)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(catid)
    REFERENCES category(catid)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
TYPE=InnoDB;



CREATE TABLE relation (
  from_nid BIGINT  NOT NULL  ,
  to_nid BIGINT  NOT NULL  ,
  rtype ENUM('m','l')  NOT NULL DEFAULT 'l'   ,
INDEX merge_FKIndex1(from_nid)  ,
INDEX merge_FKIndex2(to_nid),
  FOREIGN KEY(from_nid)
    REFERENCES node(nid)
      ON DELETE CASCADE
      ON UPDATE NO ACTION,
  FOREIGN KEY(to_nid)
    REFERENCES node(nid)
      ON DELETE CASCADE
      ON UPDATE NO ACTION);




CREATE TABLE node_comment (
  comid BIGINT  NOT NULL   AUTO_INCREMENT,
  memid BIGINT  NOT NULL  ,
  preid BIGINT  NOT NULL  ,
  nid BIGINT  NOT NULL  ,
  title VARCHAR(200)  NOT NULL  ,
  body TEXT  NOT NULL  ,
  date DATETIME  NOT NULL    ,
PRIMARY KEY(comid)  ,
INDEX node_comment_FKIndex1(nid)  ,
INDEX node_comment_FKIndex2(preid)  ,
INDEX node_comment_FKIndex3(memid),
  FOREIGN KEY(nid)
    REFERENCES node(nid)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(preid)
    REFERENCES node_comment(comid)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(memid)
    REFERENCES member(memid)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);


