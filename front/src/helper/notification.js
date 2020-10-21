import { app } from '../main';

export default {
	/**
	 * Mostra apenas um erro
	 * @param error
	 */
	showError(msg) {
		app.$toast.error(msg);
	},

	/**
	 * Mostra apenas uma mensagem de sucesso
	 * @param msg
	 */
	showSuccessMsg(msg) {
		app.$toast.success(msg);
	},

	/**
	 * Mostra warnings
	 * @param msg
	 */
	showWarning(msg) {
		app.$toast.warning(msg);
	},

	showInfoMsg(msg) {
		app.$toast.info(msg);
	},

	/**
	 * Mostra mensagem de sucesso
	 * @param success
	 */
	showSuccess(success) {
		if (success.hasOwnProperty('message')) {
			if (success.status == 'success') {
				this.showSuccessMsg(success.message);
				return;
			}
		}

		if (success.data.hasOwnProperty('message')) {
			if (success.data.status == 'success') {
				this.showSuccessMsg(success.data.message);
				return;
			}
		}
	},

	/**
	 * Trata o array de erros do serve
	 * @param arrayErros
	 */
	showErrors(error) {

		/**
		 * Se usuário não estiver autenticado no sistema
		 */
		if(error.status === 401) {
			this.showError('Usuário não autenticado. Faça o login novamente');
			return;
		}

		if (error.hasOwnProperty('data') && error.data.hasOwnProperty('status')) {
			if (error.data.status === 'error') {
				this.showError(error.data.message);
			}
			return;
		}

		/**
		 * Se for apenas um erro, mostra o único
		 */
		if (error.hasOwnProperty('data') && error.data.hasOwnProperty('error')) {
			if (error.data.error.hasOwnProperty('message')) {
				this.showError(error.data.error.message);
			}
			return;
		}

		/**
		 * Se tiver paenas a mensagem, então motra a mensagem!
		 */
		if (error.hasOwnProperty('message')) {
			this.showError(error.message);
			return;
		}

		/**
		 * Se for vários errors, então varre o array e mostra todos
		 */
		if (error.hasOwnProperty('data') && error.data.hasOwnProperty('errors')) {
			if (error.data.errors.hasOwnProperty('message')) {
				error.data.errors.message.map(error => {
					this.showError(error);
				});
			}
			return;
		}

		/**
		 * Se for vários errors, então varre o array e mostra todos
		 */
		if (error.hasOwnProperty('errors')) {
			if (error.errors.hasOwnProperty('message')) {
				error.errors.message.map(error => {
					this.showError(error);
				});
			}
			return;
		}

		/**
		 * Se não existir a propriedade error, então verifica se existe a propriedade message
		 * Questão de autorização do  usuário
		 */
		if (error.hasOwnProperty('data') && error.data.hasOwnProperty('message')) {
			this.showError(error.data.message);
		}
	},
};
