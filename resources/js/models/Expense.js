export default class Expense {
    constructor(title = '', payment = '', date = '', note = '', amount = 0, expense_type_id = null, project_id = null, account_id = null) {
        this.title = title;
        this.payment = payment;
        this.date = date;
        this.note = note;
        this.amount = amount;
        this.expense_type_id = expense_type_id;
        this.project_id = project_id;
        this.account_id = account_id;
    }
}