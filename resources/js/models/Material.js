export default class Material {
    constructor(name = '', unity = '', description = '', price = 0, material_type_id = null) {
        this.name = name;
        this.unity = unity;
        this.description = description;
        this.price = price;
        this.material_type_id = material_type_id;
    }
}