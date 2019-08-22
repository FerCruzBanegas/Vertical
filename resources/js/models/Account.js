export default class Account {
    constructor(title = '', date = '', number = '', amount = 0, note = '') {
        this.title = title;
        this.date = date;
        this.number = number;
        this.amount = amount;
        this.note = note;
    }
}