const HOUSE = 1;
const APARTMENT = 2;
const COMMERCIAL_SPACE = 3;
const LAND = 4;
const CONDO = 5;
const VILLA = 6;

const PROPERTY_TYPE = {
    [HOUSE]: 'House',
    [APARTMENT]: 'Apartment',
    [COMMERCIAL_SPACE]: 'Commercial Space',
    [LAND]: 'Land',
    [CONDO]: 'Condo',
    [VILLA]: 'Villa',
};

const NEW_CONDITION = 1;
const GOOD_CONDITION = 2;
const NEEDS_REPAIR = 3;

const CONDITION = {
    [NEW_CONDITION]: 'New',
    [GOOD_CONDITION]: 'Good',
    [NEEDS_REPAIR]: 'Needs Repair',
};

const AVAILABLE = 1;
const RENTED = 2;
const SOLD = 3;
const UNDER_MAINTENANCE = 4;
const RESERVED = 5;

const STATUS = {
    [AVAILABLE]: 'Available',
    [RENTED]: 'Rented',
    [SOLD]: 'Sold',
    [UNDER_MAINTENANCE]: 'Under Maintenance',
    [RESERVED]: 'Reserved',
};

export default class PropertyHelper {
    static getTypeById(id) {
        return PROPERTY_TYPE[id] || 'Unknown Property Type';
    }

    static getConditionById(id) {
        return CONDITION[id] || 'Unknown Condition';
    }

    static getStatusById(id) {
    return STATUS[id] || 'Unknown Status';
}
}
