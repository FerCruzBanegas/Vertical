export default class Income {
    constructor(title = '', payment = '', date = '', note = '', amount = 0, income_type_id = null, project_id = null, account_id = null) {
        this.title = title;
        this.payment = payment;
        this.date = date;
        this.note = note;
        this.amount = amount;
        this.income_type_id = income_type_id;
        this.project_id = project_id;
        this.account_id = account_id;
    }
}