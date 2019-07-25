export default class Profile {
    constructor(description = '', action_list = [], actions = Object) {
        this.description = description;
        this.action_list = action_list;
        this.actions = actions;
    }
}