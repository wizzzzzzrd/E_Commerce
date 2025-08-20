<?php include 'fragmentos/header.php'; ?>
<main class="flex-grow-1">
  <br><br>
  <form id="order-form" action="controlador/save_order.php" method="post">
    <!-- Hidden fields to capture totals and methods -->
    <input type="hidden" name="delivery_method" id="delivery_method" value="">
    <input type="hidden" name="metodo_pago" id="metodo_pago" value="">
    <input type="hidden" name="total" id="total-amount-hidden" value="0.00">
    <input type="hidden" name="cart_items" id="cart-items-hidden" value="[]">
    <!-- Hidden shipping fields -->
    <input type="hidden" name="full_name" id="hidden_fullName" value="">
    <input type="hidden" name="email" id="hidden_email" value="">
    <input type="hidden" name="phone" id="hidden_phone" value="">
    <input type="hidden" name="address" id="hidden_address" value="">
    <input type="hidden" name="address2" id="hidden_address2" value="">
    <input type="hidden" name="city" id="hidden_city" value="">
    <input type="hidden" name="state" id="hidden_state" value="">
    <input type="hidden" name="zip" id="hidden_zip" value="">
    <input type="hidden" name="country" id="hidden_country" value="">
    <!-- Hidden card number for transfer -->
    <input type="hidden" name="num_card" id="hidden_num_card" value="">
    <input type="hidden" name="order_date" value="<?php echo date('Y-m-d H:i:s'); ?>">
    <input type="hidden" name="status_venta" value="no pagado">

    <div class="row mt-5">
      <div class="col-md-6 scrollable">
        <?php if (isset($_GET['status'])): ?>
          <div class="alert alert-<?php echo $_GET['status'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?php echo $_GET['status'] === 'success' ? 'Pedido guardado exitosamente.' : 'Hubo un error al guardar el pedido. Por favor, inténtalo de nuevo.'; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <h4 class="text-uppercase font-subtitle">Entrega</h4>
        <table class="table">
          <tbody>
            <tr>
              <td>
                <label class="form-check">
                  <input class="form-check-input" type="radio" name="options" id="envio"
                    data-target="#info-envio" value="envio">
                  <span class="form-check-label font-subtitle">Envío</span>
                  <i class="fas fa-truck float-end"></i>
                </label>
              </td>
            </tr>
            <tr>
              <td>
                <label class="form-check">
                  <input class="form-check-input" type="radio" name="options" id="recoger"
                    data-target="#info-recoger" value="recoger">
                  <span class="form-check-label font-subtitle">Recoger en tienda</span>
                  <i class="fas fa-store float-end"></i>
                </label>
              </td>
            </tr>
            <tr>
              <td>
                <label class="form-check">
                  <input class="form-check-input" type="radio" name="options" id="uber"
                    data-target="#info-uber" value="uber">
                  <span class="form-check-label font-subtitle">Uber</span>
                  <i class="fas fa-car float-end"></i>
                </label>
              </td>
            </tr>
          </tbody>
        </table>
        <!-- Info Envío: inputs + labels -->
        <div id="info-envio" class="collapse mt-3">
          <div class="form-floating mb-3">
            <input type="text" class="form-control font-body" id="fullName" name="full_name" placeholder=" " required>
            <label for="fullName" class="font-subtitle">Nombre Completo*</label>
          </div>
          <div class="form-floating mb-3">
            <input type="email" class="form-control font-body" id="email" name="email" placeholder=" " required>
            <label for="email" class="font-subtitle">Correo Electrónico*</label>
          </div>
          <div class="form-floating mb-3">
            <input type="tel" class="form-control font-body" id="phone" name="phone" placeholder=" " required>
            <label for="phone" class="font-subtitle">Teléfono*</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control font-body" id="address" name="address" placeholder=" " required>
            <label for="address" class="font-subtitle">Dirección*</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control font-body" id="address2" name="address2" placeholder=" ">
            <label for="address2" class="font-subtitle">Dirección 2 (opcional)</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control font-body" id="city" name="city" placeholder=" " required>
            <label for="city" class="font-subtitle">Ciudad*</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control font-body" id="state" name="state" placeholder=" " required>
            <label for="state" class="font-subtitle">Estado/Provincia*</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control font-body" id="zip" name="zip" placeholder=" " required>
            <label for="zip" class="font-subtitle">Código Postal*</label>
          </div>
          <div class="form-floating mb-3">
            <select class="form-select font-body" id="country" name="country" required>
              <option value="">Seleccione un país...</option>
              <option value="es">España</option>
              <option value="mx">México</option>
              <option value="us">Estados Unidos</option>
              <option value="ar">Argentina</option>
            </select>
            <label for="country" class="font-subtitle">País*</label>
          </div>
        </div>
        <!-- Info Recoger: títulos y párrafos -->
        <div id="info-recoger" class="collapse mt-3">
          <div class="row" style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
            <div class="col-6">
              <h5 class="mb-1 font-subtitle" style="font-size: 14px;">Nissarana Belleza <span class="text-muted" id="distance">(Calculando...)</span></h5>
              <p class="mb-0 font-body" style="font-size: 12px;">18 Calle del Correo Mayor, Ciudad de México DF</p>
            </div>
            <div class="col-6 text-end">
              <h5 class="mb-1 font-subtitle" style="font-size: 14px;">Gratis</h5>
              <p class="mb-0 font-body" style="font-size: 12px;">Normalmente está listo en 24 horas</p>
            </div>
          </div>
        </div>
        <!-- Info Uber: títulos y párrafos -->
        <div id="info-uber" class="collapse mt-3">
          <div class="row" style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
            <div class="col-6">
              <h5 class="mb-1 font-subtitle" style="font-size: 14px;">Uber</h5>
              <p class="mb-0 font-body" style="font-size: 12px;">Horario: Disponible de 9:00 AM a 9:00 PM</p>
            </div>
            <div class="col-6 text-end">
              <h5 class="mb-1 font-subtitle" style="font-size: 14px;">Gratis</h5>
            </div>
          </div>
        </div>
        <hr class="my-4">

        <!-- PayPal Express: texto y botón -->
        <div class="text-center mb-4">
          <p class="font-subtitle">Pago exprés</p>
          <button type="button" class="btn font-subtitle" id="paypal-button" style="background-color:#FFC439; color:#003087; border:1px solid #003087; width:250px; height:50px;">
            <i class="fab fa-paypal me-2"></i> PayPal
          </button>
        </div>

        <div class="d-flex align-items-center justify-content-center">
          <div class="border-top flex-grow-1 mx-2"></div><span class="font-subtitle">O</span>
          <div class="border-top flex-grow-1 mx-2"></div>
        </div>

        <!-- Transferencia -->
        <div class="accordion mt-3" id="paymentAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTransfer">
              <button class="accordion-button collapsed font-subtitle" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTransfer">
                Pago con Transferencia
              </button>
            </h2>
            <!-- Transferencia: labels + inputs -->
            <div id="collapseTransfer" class="accordion-collapse collapse" aria-labelledby="headingTransfer" data-bs-parent="#paymentAccordion">
              <div class="accordion-body">
                <p class="text-center small text-muted mb-4 font-body">
                  Número de cuenta: <strong>1234 5678 9012 3456</strong><br>
                  Concepto: <strong>Pago de productos</strong>
                </p>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control font-body" id="nameTransfer" name="name" placeholder=" " required>
                  <label for="nameTransfer" class="font-subtitle">Nombre Completo</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="email" class="form-control font-body" id="emailTransfer" name="email" placeholder=" " required>
                  <label for="emailTransfer" class="font-subtitle">Correo</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control font-body" id="phoneTransfer" name="phone" placeholder=" " required>
                  <label for="phoneTransfer" class="font-subtitle">Teléfono</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control font-body" id="numCardTransfer" name="num_card" placeholder=" " required>
                  <label for="numCardTransfer" class="font-subtitle">Número de Tarjeta</label>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Botón Enviar (escritorio) -->
        <button type="submit" class="btn btn-primary w-100 mt-3 d-none d-lg-block font-subtitle">Enviar</button>

      </div>

      <!-- Resumen de pedido -->
      <div class="col-md-6 mt-4 mt-md-0">
        <hr class="my-4 d-block d-md-none">
        <div class="mt-lg-5 d-block d-lg-block sticky-top" style="background-color: white; z-index: 1020;">
          <h5 class="d-none d-sm-block">&nbsp;</h5>
          <h5 class="d-none d-sm-block">&nbsp;</h5>
          <h4 class="d-block d-lg-none fs-7 font-weight-bold text-dark font-subtitle text-uppercase">Resumen de Pedido</h4>
          <ul id="cart-items" class="list-group list-group-flush mb-0 font-body"></ul>
          <div class="mt-3">
            <strong class="font-subtitle">Total <span id="total-amount" class="font-price">0.00</span> MXN</strong>
          </div>
          <!-- Botón Enviar (móvil) -->
          <button type="submit" form="order-form" class="btn btn-primary w-100 mt-3 d-block d-lg-none font-subtitle">Enviar</button>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal PayPal -->
  <div class="modal fade" id="payPalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-subtitle"><i class="fab fa-paypal"></i> Pago PayPal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="paypal-button-container"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- PayPal SDK -->
  <script src="https://www.paypal.com/sdk/js?client-id=AUw6zSxW398baJ_-z5wRipGoCut-mmcFC1Kc37haJrPbii-WXgWK-2K1BBrPFm3d-oadaw7Yldf5Fgmy&currency=MXN"></script>

  <script>
    function updateRequiredFields(method) {
      ['fullName', 'email', 'phone', 'address', 'city', 'state', 'zip', 'country'].forEach(id => {
        const f = document.getElementById(id);
        if (!f) return;
        if (method === 'envio') f.setAttribute('required', 'required');
        else f.removeAttribute('required');
      });
    }

    function toggleOptions(el) {
      document.querySelectorAll('.collapse').forEach(c => c.classList.remove('show'));
      const tgt = el.dataset.target;
      if (tgt) document.querySelector(tgt).classList.add('show');
      document.getElementById('delivery_method').value = el.value;
      updateRequiredFields(el.value);
    }

    document.querySelectorAll('input[name="options"]').forEach(r => r.addEventListener('change', () => toggleOptions(r)));
    window.addEventListener('DOMContentLoaded', () => {
      const c = document.querySelector('input[name="options"]:checked');
      if (c) toggleOptions(c);
    });

    document.getElementById('collapseTransfer')?.addEventListener('show.bs.collapse', () => {
      document.getElementById('metodo_pago').value = 'transferencia';
      document.getElementById('hidden_fullName').value = document.getElementById('nameTransfer').value;
      document.getElementById('hidden_email').value = document.getElementById('emailTransfer').value;
      document.getElementById('hidden_phone').value = document.getElementById('phoneTransfer').value;
      document.getElementById('hidden_num_card').value = document.getElementById('numCardTransfer').value;
    });

    document.getElementById('order-form').addEventListener('submit', () => {
      document.getElementById('total-amount-hidden').value = document.getElementById('total-amount').innerText;
      document.getElementById('cart-items-hidden').value = localStorage.getItem('cart') || '[]';
    });

    const payPalModalEl = document.getElementById('payPalModal');
    const payPalModal = new bootstrap.Modal(payPalModalEl);
    document.getElementById('paypal-button').addEventListener('click', () => payPalModal.show());
    payPalModalEl.querySelector('.btn-close').addEventListener('click', () => payPalModal.hide());

    function updateOrderAndRedirect(details) {
      const delivery = document.getElementById('delivery_method').value;
      if (delivery === 'envio') {
        ['fullName', 'email', 'phone', 'address', 'address2', 'city', 'state', 'zip', 'country']
        .forEach(id => document.getElementById('hidden_' + id).value = document.getElementById(id).value);
      }
      document.getElementById('metodo_pago').value = 'paypal';
      document.getElementById('total-amount-hidden').value = details.purchase_units[0].amount.value;
      document.getElementById('cart-items-hidden').value = JSON.stringify(JSON.parse(localStorage.getItem('cart') || '[]'));
      const payload = {
        order_id: details.id,
        name: details.payer.name.given_name + ' ' + details.payer.name.surname,
        email: details.payer.email_address,
        phone: '',
        num_card: '',
        total: details.purchase_units[0].amount.value,
        order_date: new Date().toISOString().slice(0, 19).replace('T', ' '),
        status_venta: 'pagado',
        metodo_pago: 'paypal',
        delivery_method: delivery,
        cart_items: JSON.parse(localStorage.getItem('cart') || '[]'),
        shipping_info: delivery === 'envio' ? {
          fullName: document.getElementById('fullName').value,
          email: document.getElementById('email').value,
          phone: document.getElementById('phone').value,
          address: document.getElementById('address').value,
          address2: document.getElementById('address2').value,
          city: document.getElementById('city').value,
          state: document.getElementById('state').value,
          zip: document.getElementById('zip').value,
          country: document.getElementById('country').value
        } : null
      };
      fetch('controlador/save_orderP.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(payload)
        })
        .then(r => r.json()).then(d => {
          if (d.status === 'success') location.href = 'confirmation.php';
          else alert('Error: ' + (d.message || 'desconocido'));
        })
        .catch(e => {
          console.error(e);
          alert('Error al guardar el pedido');
        });
    }

    paypal.Buttons({
      style: {
        color: 'blue',
        shape: 'pill',
        label: 'pay'
      },
      createOrder: (_, a) => a.order.create({
        purchase_units: [{
          amount: {
            value: document.getElementById('total-amount').innerText
          }
        }]
      }),
      onApprove: (_, a) => a.order.capture().then(updateOrderAndRedirect),
      onCancel: () => alert('Pago Cancelado')
    }).render('#paypal-button-container');
  </script>

  <?php include 'fragmentos/OffCart.php'; ?>
</main>
<?php include 'fragmentos/footer.php'; ?>