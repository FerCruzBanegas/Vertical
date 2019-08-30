export default class Account {
    constructor(date_init = '', date_end = '', amount = 0, note = '') {
        this.date_init = date_init;
        this.date_end = date_end;
        this.amount = amount;
        this.note = note;
    }
}