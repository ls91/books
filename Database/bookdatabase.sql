DROP TABLE IF EXISTS RawTable;
CREATE TABLE RawTable (
  ISBN VARCHAR(20),
  BookName VARCHAR(100),
  AFN VARCHAR(100),
  AMN VARCHAR(100),
  ASN VARCHAR(100),
  Series VARCHAR(100),
  NoSeries INT UNSIGNED,
  RawBookType VARCHAR(100),
  NoPages INT UNSIGNED,
  RawStatus VARCHAR(100),
  ReadTimes INT UNSIGNED,
  RawComments VARCHAR(100),
  Image VARCHAR(100)
);
LOAD DATA LOCAL INFILE 'SuppliedData.csv' INTO TABLE RawTable
FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n';


DROP TABLE IF EXISTS AuthorTable;
CREATE TABLE AuthorTable (
  AuthorID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  AuthorFN VARCHAR(100) NOT NULL,
  AuthorMN VARCHAR(100),
  AuthorSN VARCHAR(100),
  UNIQUE KEY AuthorNameKey(AuthorFN, AuthorMN, AuthorSN)
);
INSERT IGNORE INTO AuthorTable (AuthorFN, AuthorMN, AuthorSN) SELECT AFN, AMN, ASN FROM RawTable;


DROP TABLE IF EXISTS BookTable;
CREATE TABLE BookTable (
  ISBN VARCHAR(20) PRIMARY KEY NOT NULL,
  BookTitle VARCHAR(100) NOT NULL,
  UNIQUE KEY BookKey(ISBN, BookTitle)
);
INSERT IGNORE INTO BookTable (ISBN, BookTitle) SELECT ISBN, BookName FROM RawTable;


DROP TABLE IF EXISTS BookSeriesTable;
CREATE TABLE BookSeriesTable (
  BSerID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  SeriesName VARCHAR(100),
  UNIQUE KEY BookSeriesKey(SeriesName)
);
INSERT IGNORE INTO BookSeriesTable (SeriesName) SELECT Series FROM RawTable;


DROP TABLE IF EXISTS BookTypeTable;
CREATE TABLE BookTypeTable (
  BTID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  BookType VARCHAR(100) NOT NULL,
  UNIQUE KEY BookTypeKey(BookType)
);
INSERT IGNORE INTO BookTypeTable (BookType) SELECT RawBookType FROM RawTable;


DROP TABLE IF EXISTS BookStatusTable;
CREATE TABLE BookStatusTable (
  BStatID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  BookStatus VARCHAR(100) NOT NULL,
  UNIQUE KEY BookStatusKey(BookStatus)
);
INSERT IGNORE INTO BookStatusTable (BookStatus) SELECT RawStatus FROM RawTable;


DROP TABLE IF EXISTS BookDataTable;
CREATE TABLE BookDataTable (
  ISBN VARCHAR(20) PRIMARY KEY,
  AuthorID INT UNSIGNED NOT NULL,
  SeriesID INT UNSIGNED NOT NULL,
  NoInSeries INT UNSIGNED NULL,
  Pages INT UNSIGNED NOT NULL,
  BookTypeID INT UNSIGNED NOT NULL,
  Comments VARCHAR(100),
  ImageURL VARCHAR(100),
  UNIQUE KEY BookDataKey(ISBN, AuthorID, SeriesID, NoInSeries, Pages, BookTypeID, Comments, ImageURL)
);
INSERT IGNORE INTO BookDataTable (ISBN, AuthorID, SeriesID, NoInSeries, Pages, BookTypeID, Comments, ImageURL) SELECT ISBN, AuthorID, BSerID, NoSeries, NoPages, BTID, RawComments, Image FROM RawTable, AuthorTable, BookSeriesTable, BookTypeTable WHERE AFN = AuthorFN && AMN = AuthorMN && ASN = AuthorSN && SeriesName = Series && BookType = RawBookType;


DROP TABLE IF EXISTS CurrentBookStatusTable;
CREATE TABLE CurrentBookStatusTable (
  ISBN VARCHAR(20) PRIMARY KEY,
  StatusID INT UNSIGNED NOT NULL,
  NoTimesRead INT UNSIGNED NOT NULL,
  UNIQUE KEY CurrentBSKey(ISBN, StatusID, NoTimesRead)
);
INSERT IGNORE INTO CurrentBookStatusTable (ISBN, StatusID, NoTimesRead) SELECT ISBN, BStatID, ReadTimes FROM RawTable, BookStatusTable WHERE RawStatus = BookStatus;

