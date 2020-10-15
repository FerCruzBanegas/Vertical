export default class People {
    constructor(name = '', surnames = '', phone = '', position_id = null, note = '') {
        this.name = name;
        this.surnames = surnames;
        this.phone = phone;
        this.position_id = position_id;
        this.note = note;
    }
}