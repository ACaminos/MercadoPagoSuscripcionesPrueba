<body>
    <!-- Step #2 -->
<form id="form-checkout" >
   <input type="text" name="cardNumber" id="form-checkout__cardNumber" /><br>
   <input type="text" name="cardExpirationMonth" id="form-checkout__cardExpirationMonth" /><br>
   <input type="text" name="cardExpirationYear" id="form-checkout__cardExpirationYear" /><br>
   <input type="text" name="cardholderName" id="form-checkout__cardholderName"/><br>
   <input type="email" name="cardholderEmail" id="form-checkout__cardholderEmail"/><br>
   <input type="text" name="securityCode" id="form-checkout__securityCode" /><br>
   <select name="issuer" id="form-checkout__issuer"></select><br>
   <select name="identificationType" id="form-checkout__identificationType"></select><br>
   <input type="text" name="identificationNumber" id="form-checkout__identificationNumber"/><br>
   <select name="installments" id="form-checkout__installments"></select><br>
   <button type="submit" id="form-checkout__submit">Pagar</button><br>
   <progress value="0" class="progress-bar">Cargando...</progress><br>
</form>
   <!-- Add step #2 -->
   <script src="https://sdk.mercadopago.com/js/v2"></script>
   <script>
       const mp = new MercadoPago('TEST-f826f881-0102-4eea-9cab-629423fc9067');
       // Add step #3
   </script>
   <script>
       // Step #3
const cardForm = mp.cardForm({
  amount: "100.5",
  autoMount: true,
  form: {
    id: "form-checkout",
    cardholderName: {
      id: "form-checkout__cardholderName",
      placeholder: "Titular de la tarjeta",
    },
    cardholderEmail: {
      id: "form-checkout__cardholderEmail",
      placeholder: "E-mail",
    },
    cardNumber: {
      id: "form-checkout__cardNumber",
      placeholder: "Número de la tarjeta",
    },
    cardExpirationMonth: {
      id: "form-checkout__cardExpirationMonth",
      placeholder: "Mes de vencimiento",
    },
    cardExpirationYear: {
      id: "form-checkout__cardExpirationYear",
      placeholder: "Año de vencimiento",
    },
    securityCode: {
      id: "form-checkout__securityCode",
      placeholder: "Código de seguridad",
    },
    installments: {
      id: "form-checkout__installments",
      placeholder: "Cuotas",
    },
    identificationType: {
      id: "form-checkout__identificationType",
      placeholder: "Tipo de documento",
    },
    identificationNumber: {
      id: "form-checkout__identificationNumber",
      placeholder: "Número de documento",
    },
    issuer: {
      id: "form-checkout__issuer",
      placeholder: "Banco emisor",
    },
  },
  callbacks: {
    onFormMounted: error => {
      if (error) return console.warn("Form Mounted handling error: ", error);
      console.log("Form mounted");
    },
    onSubmit: event => {
      event.preventDefault();

      const {
        paymentMethodId: payment_method_id,
        issuerId: issuer_id,
        cardholderEmail: email,
        amount,
        token,
        installments,
        identificationNumber,
        identificationType,
      } = cardForm.getCardFormData();

      fetch("/process_payment", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          token,
          issuer_id,
          payment_method_id,
          transaction_amount: Number(amount),
          installments: Number(installments),
          description: "Descripción del producto",
          payer: {
            email,
            identification: {
              type: identificationType,
              number: identificationNumber,
            },
          },
        }),
      });
    },
    onFetching: (resource) => {
      console.log("Fetching resource: ", resource);

      // Animate progress bar
      const progressBar = document.querySelector(".progress-bar");
      progressBar.removeAttribute("value");

      return () => {
        progressBar.setAttribute("value", "0");
      };
    },
  },
});
   </script>
</body>