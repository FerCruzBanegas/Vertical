export default class SmallBox {
    constructor(date_init = '', date_end = '', start_amount = 0, used_amount = 0, account_id = null, user_id = null, note = '') {
        this.date_init = date_init;
        this.date_end = date_end;
        this.start_amount = start_amount;
        this.used_amount = used_amount;
        this.user_id = user_id;
        this.account_id = account_id;
        this.note = note;
    }
}