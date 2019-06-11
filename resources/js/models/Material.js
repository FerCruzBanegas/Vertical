export default class Material {
    constructor(name = '', unity = '', description = '', price = 0, category_id = null) {
        this.name = name;
        this.unity = unity;
        this.description = description;
        this.price = price;
        this.category_id = category_id;
    }
}