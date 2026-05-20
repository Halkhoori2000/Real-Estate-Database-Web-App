
/*
SELECT 
  h.Id, h.Bedrooms, h.LotSize, h.Extras,
  l.Address, l.ZipCode,
  a.AreaType,
  s.Style, 
  c.Construction
FROM House h
LEFT JOIN Location l ON h.Id = l.HouseId 
LEFT JOIN AreaType a ON l.AreaTypeId = a.Id
LEFT JOIN Style s ON h.StyleId = s.Id 
LEFT JOIN Construction c ON h.ConstructionId = c.Id 
;

SELECT 
  hf.HouseId, 
  fc.FeatureCategory,
  f.Description
FROM HouseFeatures hf 
LEFT JOIN Feature f ON hf.FeatureId = f.Id 
LEFT JOIN FeatureCategory fc ON f.FeatureCategoryId = fc.Id 
;

SELECT 
  f.Id, 
  fc.FeatureCategory,
  f.Description
FROM Feature f 
LEFT JOIN FeatureCategory fc ON f.FeatureCategoryId = fc.Id
ORDER BY f.FeatureCategoryId ASC 
;

SELECT 
  f.Id, 
  fc.FeatureCategory,
  f.Description,
  hf.Id HouseFeatureId
FROM Feature f 
LEFT JOIN FeatureCategory fc ON f.FeatureCategoryId = fc.Id
LEFT JOIN HouseFeatures hf ON (f.Id = hf.FeatureId AND hf.HouseId = 1)
ORDER BY f.FeatureCategoryId ASC 
;
*/

/*
SELECT 
  h.HouseId, 
  h.HouseBuilt,
  h.HouseListed,
  h.HouseAddress,
  a.AddressStreet,
  a.AddressZipCode,
  a.AddressCity, 
  a.AddressCountry,
  h.HouseRooms,
  h.HouseBedrooms,
  h.HouseBathrooms,
  h.HouseGarage,
  h.HouseDescription,
  h.HouseLotSize,
  h.HouseArea
FROM House h
LEFT JOIN Address a ON h.HouseId = a.HouseId
ORDER BY h.HouseId
;
*/
SELECT 
        f.FeatureId, 
        fc.FeatureCategory,
        f.FeatureDescription
      FROM Feature f 
      LEFT JOIN FeatureCategory fc ON f.FeatureCategoryId = fc.FeatureCategoryId
      ORDER BY f.FeatureCategoryId ASC 
      ;

SELECT f.FeatureId, fc.FeatureCategory, f.FeatureDescription, hf.HouseFeatureId HouseFeatureId FROM Feature f LEFT JOIN FeatureCategory fc ON f.FeatureCategoryId = fc.FeatureCategoryId LEFT JOIN HouseFeatures hf ON (f.FeatureId = hf.FeatureId AND hf.HouseId = 55) ORDER BY f.FeatureCategoryId ASC ;
