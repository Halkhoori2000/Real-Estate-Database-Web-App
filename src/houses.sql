-- Creates the tables in the current database
CREATE TABLE House
(
  HouseId INT AUTO_INCREMENT,
  HouseBuilt DATE NOT NULL,
  HouseListed DATETIME NOT NULL,
  HouseAddress VARCHAR(128) NOT NULL,
  HouseRooms INT NOT NULL,
  HouseBedrooms INT NOT NULL,
  HouseBathrooms INT NOT NULL,
  HouseGarage INT NOT NULL,
  HouseDescription TEXT NOT NULL,
  HouseLotSize INT, 
  HouseArea INT,

  PRIMARY KEY(HouseId)
);

CREATE TABLE Address 
(
  AddressId INT AUTO_INCREMENT,
  AddressStreet VARCHAR(128) NOT NULL,
  AddressZipCode INT NOT NULL,
  AddressCity VARCHAR(64) NOT NULL, 
  AddressCountry VARCHAR(64) NOT NULL,
  HouseId INT NOT NULL,

  PRIMARY KEY(AddressId),
  FOREIGN KEY(HouseId) REFERENCES House(HouseId) ON DELETE CASCADE 
);

CREATE TABLE FeatureCategory
(
  FeatureCategoryId INT AUTO_INCREMENT,
  FeatureCategory VARCHAR(64) NOT NULL,

  PRIMARY KEY(FeatureCategoryId),
  UNIQUE(FeatureCategory)
);

CREATE TABLE Feature 
(
  FeatureId INT AUTO_INCREMENT,
  FeatureDescription VARCHAR(64) NOT NULL,
  FeatureCategoryId INT NOT NULL,

  PRIMARY KEY(FeatureId),
  FOREIGN KEY(FeatureCategoryId) REFERENCES FeatureCategory(FeatureCategoryId) ON DELETE CASCADE
);

CREATE TABLE HouseFeature 
(
  HouseFeatureId INT AUTO_INCREMENT,
  FeatureId INT NOT NULL, 
  HouseId INT NOT NULL,

  PRIMARY KEY(HouseFeatureId),
  UNIQUE(HouseId, FeatureId),
  FOREIGN KEY(FeatureId) REFERENCES Feature(FeatureId) ON DELETE CASCADE, 
  FOREIGN KEY(HouseId) REFERENCES House(HouseId) ON DELETE CASCADE
);

CREATE TABLE Person 
(
  PersonId INT AUTO_INCREMENT, 
  PersonFirstName VARCHAR(64) NOT NULL, 
  PersonLastName VARCHAR(64) NOT NULL, 
  PersonAddress VARCHAR(128) NOT NULL,
  Email VARCHAR(256) NOT NULL, 
  Username VARCHAR(32) NOT NULL, 
  Password VARCHAR(32) NOT NULL,
  BirthDate DATE NOT NULL,
  PersonCreated DATETIME NOT NULL,

  PRIMARY KEY(PersonId),
  UNIQUE (Username),
  UNIQUE (Email)
);

CREATE TABLE Agent 
(
  AgentId INT AUTO_INCREMENT,
  AgentName VARCHAR(32) NOT NULL,
  AgentPhone VARCHAR(64) NOT NULL,
  PersonId INT,

  PRIMARY KEY(AgentId),
  UNIQUE(AgentName),
  FOREIGN KEY(PersonId) REFERENCES Person(PersonId) ON DELETE SET NULL
);

CREATE TABLE Owner 
(
  OwnerId INT AUTO_INCREMENT,
  OwnerName VARCHAR(32) NOT NULL,
  OwnerPhone VARCHAR(64) NOT NULL,
  PersonId INT NOT NULL,
  HouseId INT,

  PRIMARY KEY(OwnerId),
  UNIQUE(OwnerName),
  UNIQUE(PersonId, HouseId),
  FOREIGN KEY(PersonId) REFERENCES Person(PersonId) ON DELETE CASCADE,
  FOREIGN KEY(HouseId) REFERENCES House(HouseId) ON DELETE SET NULL
);

CREATE TABLE HouseForSale
(
  HouseForSaleId INT AUTO_INCREMENT,
  HouseId INT NOT NULL,
  HousePrice DECIMAL(20) NOT NULL,
  DatePosted DATETIME NOT NULL,

  PRIMARY KEY(HouseForSaleId),
  FOREIGN KEY(HouseId) REFERENCES House(HouseId) ON DELETE CASCADE 
);

CREATE TABLE Sale 
(
  SaleId INT AUTO_INCREMENT,
  HouseForSaleId INT NOT NULL,
  SaleDate DATE NOT NULL,

  PRIMARY KEY(SaleId),
  FOREIGN KEY(HouseForSaleId) REFERENCES HouseForSale(HouseForSaleId) ON DELETE CASCADE
);

