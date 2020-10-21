import Api from '$services/api';

class User extends Api {
    constructor(url) {
        super(url);
    }
}


export default new User('user');
