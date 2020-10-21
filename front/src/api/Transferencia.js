import Api from '$services/api';

class Transferencia extends Api {
    constructor(url) {
        super(url);
    }
}

export default new Transferencia('transaction');
