# Klaviyo Integration

DXN landing page leads are posted to `/api/dxn-lead`, saved in `dxn_leads`, and synced to Klaviyo through `App\Jobs\SyncDxnLeadToKlaviyo`.

## Required environment values

Set these in `laravel-server/.env`:

```env
KLAVIYO_PRIVATE_API_KEY=pk_your_private_key
KLAVIYO_LIST_ID=your_list_id
KLAVIYO_COMPANY_ID=your_public_company_id
KLAVIYO_REVISION=2026-04-15
```

The private key needs these Klaviyo scopes:

```text
profiles:write
lists:write
subscriptions:write
```

After changing `.env`, refresh Laravel config:

```bash
php artisan config:clear
```

## Check the connection

Check whether Laravel can see the Klaviyo values without printing the private key:

```bash
php artisan dxn:klaviyo-status
```

Send one explicit test profile to the configured Klaviyo list:

```bash
php artisan dxn:test-klaviyo test@example.com --name="Klaviyo Test Lead"
```

## Queue processing

If `QUEUE_CONNECTION=database`, run a worker so queued leads sync:

```bash
php artisan queue:work --queue=klaviyo,default
```

If `QUEUE_CONNECTION=sync`, the lead sync runs during the request.
