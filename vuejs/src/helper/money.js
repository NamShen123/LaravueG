export const money = {
    format: (price, currency='VND') => {
        let moneyUnit =  new Intl.NumberFormat('vn', {
            style: 'currency',
            currency: currency,
        });
        return moneyUnit.format(price);
    }
}