export default class PriceFormatHelper {
    static formatPrice(value, currency = 'USD') {
        if (isNaN(value)) return 'NaN';

        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency,
        }).format(value);
    }
}
