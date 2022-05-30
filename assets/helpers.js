const declineWord = (amount, forms) => {
  const n = Math.abs(amount) % 100;
  const n1 = n % 10;

  if (n > 10 && n < 20) {
    return forms[2];
  }

  if (n1 > 1 && n1 < 5) {
    return forms[1];
  }

  if (n1 === 1) {
    return forms[0];
  }

  return forms[2];
};

// eslint-disable-next-line import/prefer-default-export
export { declineWord };
