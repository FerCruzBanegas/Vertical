export default class User {
    constructor(name = '', email = '', pass = '', password = '', password_confirmation ="" , profile_id = '', active='') {
        this.name = name;
        this.email = email;
        this.pass = pass;
        this.password = password;
        this.profile_id = profile_id;
        this.active = active;
    }
}