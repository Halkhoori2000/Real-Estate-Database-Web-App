# Generates a random data to be used in the houses database

import random


# Define house data generator
def generate_house_rows(n: int):
    # Generate the insert query
    yield 'INSERT INTO House(HouseBuilt, HouseListed, HouseAddress, HouseRooms, HouseBedrooms, HouseBathrooms, HouseGarage, HouseDescription, HouseLotSize, HouseArea) VALUES\n'

    # Generate the values
    for i in range(n):
        yield f"('{random.randint(1980, 2012)}-{random.randint(1, 12)}-{random.randint(1, 28)}', '{random.randint(1980, 2012)}-{random.randint(1, 12)}-{random.randint(1, 28)}', '{random.randint(1, 100)} St.', {random.randint(2, 10)}, {random.randint(1, 5)}, {random.randint(1, 4)}, {random.randint(0, 4)}, 'Sample description {i}', {50 * random.randint(1, 30)}, {50 * random.randint(1, 30)})" \
            + (',' if i < (n - 1) else ';') + "\n"

# Define function to truncate table


def clear_tables(tables: list[str]):
    yield 'SET FOREIGN_KEY_CHECKS = 0;\n'
    for table in tables:
        yield f'TRUNCATE TABLE {table};\n'
    yield 'SET FOREIGN_KEY_CHECKS = 1;\n'

# Define address data generator


def generate_address_rows(n: int, cities: list[str], countries: list[str]):
    # Generate the insert query
    yield 'INSERT INTO Address(AddressStreet, AddressZipCode, AddressCity, AddressCountry, HouseId) VALUES\n'

    # Generate the values
    for i in range(n):
        yield f"('{random.randint(1, 100)} St.', {random.randint(0, 100000)}, '{random.choice(cities)}', '{random.choice(countries)}', {i + 1})" \
            + (',' if i < (n - 1) else ';') + "\n"

# Define feature generator


def generate_feature_rows(features: dict):
    # Generate the feature categories
    categories = list(features.keys())
    yield 'INSERT INTO FeatureCategory(FeatureCategory) VALUES\n'

    n = len(categories)
    for i in range(n):
        category = categories[i]
        yield f"('{category}')" + (',' if i < (n - 1) else ';') + "\n"

    # Generate the features
    yield 'INSERT INTO Feature(FeatureDescription, FeatureCategoryId) VALUES\n'

    n = len(categories)
    for i in range(n):
        category = categories[i]

        m = len(features[category])
        for j in range(m):
            feature = features[category][j]
            yield f"('{feature}', {i + 1})" + (';' if i == (n - 1) and j == (m - 1) else ',') + "\n"

# Define house feature generator


def generate_house_feature_rows(num_houses: int, features: dict):
    # Generate insert sql
    yield 'INSERT INTO HouseFeature(FeatureId, HouseId) VALUES\n'

    # Count the number of features
    num_features = sum([len(features[category]) for category in features])
    featureIds = list(range(1, num_features + 1))

    # Generate n features on random houses
    for i in range(num_houses):
        # Generate a random number of features for each house
        num_f = random.randint(1, num_features)

        # For each feature
        fs = random.sample(featureIds, k=num_f)
        for j in range(num_f):
            f = fs[j]
            yield f"({f}, {i + 1})" + (';' if i == (num_houses - 1) and j == (num_f - 1) else ',') + "\n"

# Define function to generate persons


def generate_person_rows(n: int, names: list[str], cities: list[str]):
    # Generate insert sql
    yield 'INSERT INTO Person(PersonFirstName, PersonLastName, PersonAddress, Email, Username, Password, BirthDate, PersonCreated) VALUES\n'

    # Generate the values
    for i in range(n):
        yield f"('{random.choice(names)}{i}','{random.choice(names)}{i}','{random.choice(cities)} City','{random.choice(names)}{i}.{random.choice(names)}@gmail.com', '{random.choice(names)}{i+1}', 'TestPassword', '{random.randint(1980, 2012)}-{random.randint(1, 12)}-{random.randint(1, 28)}','{random.randint(1980, 2012)}-{random.randint(1, 12)}-{random.randint(1, 28)}')" + (',' if i < (n - 1) else ';') + "\n"


# Define function to generate agents
def generate_agent_rows(n: int, n_agent: int, names: list[str]):
    # Generate insert sql
    yield 'INSERT INTO Agent(AgentName, AgentPhone, PersonId) VALUES\n'

    # Create list of person ids
    persons = list(range(1, n + 1))

    # Sample a portion as agent
    agents = random.sample(persons, n_agent)

    # Generate values
    for i in range(n_agent):
        yield f"('{random.choice(names)}{i}', '{random.randint(1000,1000000)}', {agents[i]})" + (',' if i < (n_agent - 1) else ';') + "\n"

# Define function to generate owners


def generate_owner_rows(n_houses: int, n_persons: int, names: list[str]):
    # Generate insert sql
    yield 'INSERT INTO Owner(OwnerName, OwnerPhone, PersonId, HouseId) VALUES\n'

    # Generate values
    for i in range(n_houses):
        yield f"('{random.choice(names)}{i}', '{random.randint(1000,1000000)}', {random.randint(1, n_persons)}, {i + 1})" + (',' if i < (n_houses - 1) else ';') + "\n"

# Define function to generate house for sale


def generate_house_for_sale_rows(n_houses: int, n_for_sale: int):
    # Generate insert sql
    yield 'INSERT INTO HouseForSale(HouseId, HousePrice, DatePosted) VALUES\n'

    # Sample a list of houses
    for_sale = random.sample(list(range(1, n_houses + 1)), n_for_sale)

    # Generate the values
    for i in range(n_for_sale):
        yield f"({for_sale[i]}, {random.randint(1000, 10000000)}, '{random.randint(1980, 2012)}-{random.randint(1, 12)}-{random.randint(1, 28)}')" + (',' if i < (n_for_sale - 1) else ';') + "\n"


# Define function to generate sale 
def generate_sale_rows(n_for_sale: int, n_sold: int):
  # Generate insert sql
  yield 'INSERT INTO Sale(HouseForSaleId, SaleDate) VALUES\n'

  # Sample sold houses from for sale 
  sold = random.sample(list(range(1, n_for_sale + 1)), n_sold)

  # Generate the values 
  for i in range(n_sold):
    yield f"({sold[i]}, '{random.randint(1980, 2012)}-{random.randint(1, 12)}-{random.randint(1, 28)}')" + (',' if i < (n_sold - 1) else ';') + "\n"

# Define constants
TABLES = ['House', 'Address', 'FeatureCategory', 'Feature',
          'HouseFeature', 'Person', 'Agent', 'Owner', 'HouseForSale', 'Sale']
CITIES = ['Tokyo', 'Yokohama', 'Jakarta', 'Manila', 'Seoul',
          'Shanghai', 'Karachi', 'Beijing', 'New York', 'Mexico City']
COUNTRIES = ['Japan', 'Indonesia', 'India', 'Philippines', 'South Korea',
             'China', 'Pakistan', 'United States', 'Brazil', 'Mexico']
FEATURES = {
    'Water Source': ['Well', 'Municipal'],
    'Air Conditioning': ['Window', 'Central', 'Mini-split'],
    'Heating Type': ['Coal', 'Wood', 'Gas', 'Electric']
}
NAMES = ['Liam', 'Noah', 'Oliver', 'Elijah',
         'Olivia', 'Emma', 'Charlotte', 'Amelia']

# Write the script
with open('houses-data.sql', 'w') as f:
    f.writelines(clear_tables(TABLES))
    f.writelines(generate_house_rows(250))
    f.writelines(generate_address_rows(250, CITIES, COUNTRIES))
    f.writelines(generate_feature_rows(FEATURES))
    f.writelines(generate_house_feature_rows(250, FEATURES))
    f.writelines(generate_person_rows(50, NAMES, CITIES))
    f.writelines(generate_agent_rows(50, 20, NAMES))
    f.writelines(generate_owner_rows(250, 50, NAMES))
    f.writelines(generate_house_for_sale_rows(250, 100))
    f.writelines(generate_sale_rows(100, 80))
