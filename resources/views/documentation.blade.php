@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#api" aria-controls="api" role="tab" data-toggle="tab">API</a></li>
        <li role="presentation"><a href="#oauth" aria-controls="oauth" role="tab" data-toggle="tab">Oauth</a></li>
      </ul>
    </div>
  </div>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="api">
      <div class="col-xs-12">
        <h2>Routes</h2>
      </div>
      <div class="col-xs-12">
        <pre>api entry point: <kbd>/api/v1/</kbd><br>format: <kbd>json</kbd></pre>
      </div>
      <div class="col-xs-12">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Action</th>
              <th>Route</th>
              <th>Authorized params</th>
              <th>Auth</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>GET</td>
              <td>engine</td>
              <td>
                <dl class="dl-horizontal">
                  <dt>lSport</dt>
                  <dd>[1-10]</dd>
                  <dt>waypoints</dt>
                  <dd>{unknown}</dd>
                  <dt>steps</dt>
                  <dd>{unknown}</dd>
                  <dt>distanceType</dt>
                  <dd>{unknown}</dd>
                  <dt>vConsigne</dt>
                  <dd>{unknown}</dd>
                  <dt>vehicles</dt>
                  <dd>{unknown}</dd>
                </dl>
              </td>
              <td>NO</td>
              <td>Get the engine for the car</td>
            </tr>
            <tr>
              <td>GET</td>
              <td>categories</td>
              <td></td>
              <td>No</td>
              <td>Get all existing categories</td>
            </tr>
            <tr>
              <td>GET</td>
              <td>category/{id}</td>
              <td></td>
              <td>No</td>
              <td>Get details about a specific category</td>
            </tr>
            <tr>
              <td>POST</td>
              <td>category</td>
              <td>
                <dl class="dl-horizontal">
                  <dt>name</dt>
                  <dd>{string}</dd>
                </dl>
               </td>
              <td>Yes</td>
              <td>Create a new category</td>
            </tr>
            <tr>
              <td>PUT / PATCH</td>
              <td>category/{id}</td>
              <td>
                <dl class="dl-horizontal">
                  <dt>name</dt>
                  <dd>{string}</dd>
                </dl>
              </td>
              <td>Yes</td>
              <td>Modify a category</td>
            </tr>
            <tr>
              <td>DELETE</td>
              <td>category/{id}</td>
              <td></td>
              <td>Yes</td>
              <td>Delete a category</td>
            </tr>
            <tr>
              <td>GET</td>
              <td>trips</td>
              <td></td>
              <td>No</td>
              <td>Get all trips</td>
            </tr>
            <tr>
              <td>GET</td>
              <td>trip/{id}</td>
              <td></td>
              <td>No</td>
              <td>Get a trip</td>
            </tr>
            <tr>
              <td>POST</td>
              <td>trip</td>
              <td>
                <dl class="dl-horizontal">
                  <dt>name</dt>
                  <dd>{string}</dd>
                  <dt>steps</dt>
                  <dd>{unknown}</dd>
                </dl>
              </td>
              <td>Yes</td>
              <td>Create a trip</td>
            </tr>
            <tr>
              <td>PUT / PATCH</td>
              <td>trip/{id}</td>
              <td>
                <dl class="dl-horizontal">
                  <dt>name</dt>
                  <dd>{string}</dd>
                  <dt>steps</dt>
                  <dd>{unknown}</dd>
                </dl>
              </td>
              <td>Yes</td>
              <td>Modify a trip</td>
            </tr>
            <tr>
              <td>DELETE</td>
              <td>trip/{id}</td>
              <td></td>
              <td>Yes</td>
              <td>Delete a trip</td>
            </tr>
            <tr>
              <td>GET</td>
              <td>vehicles</td>
              <td></td>
              <td>No</td>
              <td>Get all vehicles</td>
            </tr>
            <tr>
              <td>GET</td>
              <td>vehicle/{id}</td>
              <td></td>
              <td>No</td>
              <td>Get a vehicle</td>
            </tr>
            <tr>
              <td>POST</td>
              <td>vehicle</td>
              <td>
                <dl class="dl-horizontal">
                  <dt>id_ves</dt>
                  <dd>{number}</dd>
                  <dt>description</dt>
                  <dd>{string}</dd>
                  <dt>weight_empty_kg</dt>
                  <dd>{number}</dd>
                  <dt>electric_power_kw</dt>
                  <dd>{number}</dd>
                  <dt>max_speed</dt>
                  <dd>{number}</dd>
                  <dt>scx</dt>
                  <dd>{number}</dd>
                  <dt>cr</dt>
                  <dd>{number}</dd>
                  <dt>battery_kwh</dt>
                  <dd>{number}</dd>
                  <dt>picture</dt>
                  <dd>{url}</dd>
                  <dt>rdtBattDeCharge</dt>
                  <dd>{number}</dd>
                  <dt>rdtBattCharge</dt>
                  <dd>{number}</dd>
                  <dt>rdtMoteur</dt>
                  <dd>{number}</dd>
                  <dt>precup</dt>
                  <dd>{number}</dd>
                  <dt>note</dt>
                  <dd>{string}</dd>
                  <dt>category_id</dt>
                  <dd>{id}</dd>
                </dl>
              </td>
              <td>Yes</td>
              <td>Create a vehicle</td>
            </tr>
            <tr>
              <td>PUT / PATCH</td>
              <td>vehicle/{id}</td>
              <td>
                <dl class="dl-horizontal">
                  <dt>id_ves</dt>
                  <dd>{number}</dd>
                  <dt>description</dt>
                  <dd>{string}</dd>
                  <dt>weight_empty_kg</dt>
                  <dd>{number}</dd>
                  <dt>electric_power_kw</dt>
                  <dd>{number}</dd>
                  <dt>max_speed</dt>
                  <dd>{number}</dd>
                  <dt>scx</dt>
                  <dd>{number}</dd>
                  <dt>cr</dt>
                  <dd>{number}</dd>
                  <dt>battery_kwh</dt>
                  <dd>{number}</dd>
                  <dt>picture</dt>
                  <dd>{url}</dd>
                  <dt>rdtBattDeCharge</dt>
                  <dd>{number}</dd>
                  <dt>rdtBattCharge</dt>
                  <dd>{number}</dd>
                  <dt>rdtMoteur</dt>
                  <dd>{number}</dd>
                  <dt>precup</dt>
                  <dd>{number}</dd>
                  <dt>note</dt>
                  <dd>{string}</dd>
                  <dt>category_id</dt>
                  <dd>{id}</dd>
                </dl>
              </td>
              <td>Yes</td>
              <td>Modify a vehicle</td>
            </tr>
            <tr>
              <td>DELETE</td>
              <td>vehicle/{id}</td>
              <td></td>
              <td>Yes</td>
              <td>Delete a vehicle</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="oauth">
      <div class="col-xs-12">
        <h2>Client routes</h2>
      </div>
      <div class="col-xs-12">
        <pre>entry point: <kbd>/oauth/</kbd></pre>
      </div>
      <div class="col-xs-12">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Action</th>
              <th>Route</th>
              <th>Authorized params</th>
              <th>Auth</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>GET</td>
              <td>clients</td>
              <td></td>
              <td>Yes</td>
              <td>get all the clients for the autenticated user</td>
            </tr>
            <tr>
              <td>POST</td>
              <td>clients</td>
              <td>
                <dl class="dl-horizontal">
                  <dt>name</dt>
                  <dd>{client-name}</dd>
                  <dt>redirect</dt>
                  <dd>{url}</dd>
                </dl>
              </td>
              <td>Yes</td>
              <td>create a new client and return the created client instance</td>
            </tr>
            <tr>
              <td>PUT</td>
              <td>clients/{client-id}</td>
              <td>
                <dl class="dl-horizontal">
                  <dt>name</dt>
                  <dd>{client-name}</dd>
                  <dt>redirect</dt>
                  <dd>{url}</dd>
                </dl>
              </td>
              <td>Yes</td>
              <td>modify the client</td>
            </tr>
            <tr>
              <td>DELETE</td>
              <td>clients/{client-id}</td>
              <td></td>
              <td>Yes</td>
              <td>delete a client</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-xs-12">
        <h2>Token routes</h2>
      </div>
      <div class="col-xs-12">
        <pre>entry point: <kbd>/oauth/</kbd></pre>
      </div>
      <div class="col-xs-12">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Action</th>
              <th>Route</th>
              <th>Authorized params</th>
              <th>Auth</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>POST</td>
              <td>token</td>
              <td>
                <dl class="dl-horizontal">
                  <dt>grant_type</dt>
                  <dd>'password'</dd>
                  <dt>client_id</dt>
                  <dd>{id}</dd>
                  <dt>client_secret</dt>
                  <dd>{secret}</dd>
                  <dt>username</dt>
                  <dd>{string}</dd>
                  <dt>password</dt>
                  <dd>{string}</dd>
                  <dt>scope</dt>
                  <dd>{scope-name}</dd>
                </dl>
              </td>
              <td>Yes</td>
              <td>get an access token to the client with user credentials</td>
            </tr>
            <tr>
              <td>POST</td>
              <td>token</td>
              <td>
                <dl class="dl-horizontal">
                  <dt>grant_type</dt>
                  <dd>'client_credentials'</dd>
                  <dt>client_id</dt>
                  <dd>{id}</dd>
                  <dt>client_secret</dt>
                  <dd>{secret}</dd>
                  <dt>scope</dt>
                  <dd>{scope-name}</dd>
                </dl>
              </td>
              <td>Yes</td>
              <td>get an access token without credentials</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
