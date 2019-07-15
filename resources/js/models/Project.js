export default class Project {
    constructor(name = '', location ='', comments = '', start_date = '', project_type_id = null) {
        this.name = name;
        this.location = location;
        this.comments = comments;
        this.start_date = start_date;
        this.project_type_id = project_type_id;
    }
}