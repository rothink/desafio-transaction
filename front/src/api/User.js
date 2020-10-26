import Api from '$services/api';

class User extends Api {
    constructor(url) {
        super(url);
    }

    async cadastroExterno(form) {
        try {
            return await form
                .post(`${this.url}/cadastro-externo`)
                .then(res => {
                    notification.showSuccess(res);
                    return {
                        status: true,
                        message: res.message,
                        user: res.data.user
                    };
                })
                .catch(err => {
                    notification.showErrors(err);
                    return {
                        status: false,
                        error: err.message,
                        message: err.response.data.message,
                    };
                });
        } catch (error) {
            return error;
        }
    }
}


export default new User('user');
