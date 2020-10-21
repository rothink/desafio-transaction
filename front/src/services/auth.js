import passport from '../plugins/passport';

export default {
  login(form, router) {
    passport.accessToken(form, router);
  },
};
