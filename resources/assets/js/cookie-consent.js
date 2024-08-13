import axios from 'axios';
import * as CookieConsent from 'vanilla-cookieconsent';

const laravelCookieConsent = phpToJs.laravelCookieConsent;

laravelCookieConsent.config.onFirstConsent = async () => {
  await logConsent();
  checkRedirect();
};

laravelCookieConsent.config.onChange = async () => {
  await logConsent();
  checkRedirect();
};

function create() {
  if (!isEnabled()) {
    return;
  }

  CookieConsent.run(laravelCookieConsent.config);
}

function isEnabled() {
  return laravelCookieConsent.enabled !== '1';
}

async function logConsent() {
  const postRoute = laravelCookieConsent.routes.post || false;

  if (!postRoute) {
    return;
  }

  const cookie = CookieConsent.getCookie();
  const preferences = CookieConsent.getUserPreferences();

  const userConsent = {
    consentId: cookie.consentId,
    acceptType: preferences.acceptType,
    acceptedCategories: preferences.acceptedCategories,
    rejectedCategories: preferences.rejectedCategories,
  };

  try {
    const response = await axios.post(postRoute, userConsent);
    return response;
  } catch (error) {
    throw error;
  }
}

function checkRedirect() {
  if (laravelCookieConsent.routes.redirect) {
    location.href = laravelCookieConsent.routes.redirect;
  }
}

export default {
  create,
};
