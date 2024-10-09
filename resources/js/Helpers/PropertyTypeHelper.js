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

export default class PropertyTypeHelper {
    static getTypeById(id) {
        return PROPERTY_TYPE[id] || 'Unknown Property Type';
    }
}
