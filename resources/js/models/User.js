export default class User {
    constructor(name = '', email = '', password_current, password = '', password_confirmation = '' , state = null, profile_id = null) {
        this.name = name;
        this.email = email;
        this.password_current = password_current;
        this.password = password;
        this.password_confirmation = password_confirmation;
        this.state = state;
        this.profile_id = profile_id;
    }
}