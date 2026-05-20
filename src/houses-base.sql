USE houses; 

-- Clear the tables first 
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE House;  
TRUNCATE TABLE Location; 
TRUNCATE TABLE Style;
TRUNCATE TABLE Color;
TRUNCATE TABLE Construction; 
TRUNCATE TABLE AreaType;
TRUNCATE TABLE FeatureCategory;
TRUNCATE TABLE Feature;
TRUNCATE TABLE HouseFeatures;

SET FOREIGN_KEY_CHECKS = 1;

-- Load starter data for the Houses database 
INSERT INTO Style(Style) VALUES 
  ('Colonial'),
  ('Ranch'),
  ('Split-level');

INSERT INTO Color(Color, Red, Green, Blue) VALUES 
  ('Red', 255, 0, 0),
  ('Green', 0, 255, 0),
  ('Blue', 0, 0, 255);

INSERT INTO Construction(Construction) VALUES 
  ('Block'),
  ('Wood'),
  ('Steel');

INSERT INTO AreaType(AreaType) VALUES 
  ('Rural'),
  ('Suburban'),
  ('Urban');

INSERT INTO House(StyleId, Bedrooms, ExteriorColor, ConstructionId, LotSize, Extras) VALUES 
  (1, 3, 1, 1, 1, NULL),
  (2, 2, 2, 2, 1, NULL),
  (2, 2, 2, 2, 1, 'Office');

INSERT INTO Location(Address, ZipCode, AreaTypeId, HouseId) VALUES 
  ('848 South Academy St. San Pablo, CA', '94806', 1, 1),
  ('645 Woodside Street Rialto, CA', '92376', 2, 2),
  ('6 Lexington Court Chula Vista, CA', '91910', 3, 3);

INSERT INTO FeatureCategory(FeatureCategory) VALUES 
  ('Water Source'),
  ('Air Conditioning'),
  ('Heating Type');

INSERT INTO Feature(FeatureCategoryId, Description) VALUES 
  (1, 'Well'),
  (1, 'Municipal'),
  (2, 'Window'),
  (2, 'Central'),
  (2, 'Mini-split'),
  (3, 'Coal'),
  (3, 'Wood'),
  (3, 'Gas'),
  (3, 'Electric');

INSERT INTO HouseFeatures(FeatureId, HouseId) VALUES 
  (1, 1),
  (3, 1),
  (9, 1),
  (2, 2),
  (6, 2),
  (9, 2),
  (1, 3),
  (4, 3),
  (9, 3);