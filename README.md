# Godel PHP Kubernetes demo
Demo PHP kubernetes project.
This project is set up using kubernetes on Google cloud

## Installation

### Vendors installation
Run `composer install` locally

### Creating kubernetes cluster in google cloud
```
gcloud container clusters create [cluster_name] \
    --scopes "cloud-platform" \
    --num-nodes 1 \
    --enable-basic-auth \
    --issue-client-certificate \
    --enable-ip-alias \
    --zone [YOUR_GCP_ZONE]
```

### Create docker images published in google cloud
Mysql:
```bash
PROJECT_ID=google_cloud_project_id ./kubernetes/bin/docker-publish-mysql.sh
```
Nginx:
```bash
PROJECT_ID=google_cloud_project_id ./kubernetes/bin/docker-publish-nginx.sh
```
And the same for php-fpm:
```bash
PROJECT_ID=google_cloud_project_id ./kubernetes/bin/docker-publish-php-fpm.sh
```
For migration:
```bash
PROJECT_ID=google_cloud_project_id ./kubernetes/bin/docker-publish-php-cli-run-migrations.sh
```

Then edit deployment yaml files to point to the right image:
For `kuberneters/php-fpm-deployment.yaml` replace `dark-hall-244312` with your google project ID. The same for other deployment files.

### Further kubernetes objects creations

* Run `kubectl create secret generic mysql --from-literal url=mysql://godel-k8s-demo:42@mysql:3306/godel-k8s-demo` to create a database secret for php workers
* Then create mysql volume: `kubectl create -f kubernetes/mysql-volume.yaml`
* Mysql service: `kubectl create -f kubernetes/mysql-deployment.yaml`
* PHP fpm deployment: `kubectl create -f kubernetes/php-fpm-deployment.yaml`
* PHP service: `kubectl create -f kubernetes/php-fpm-service.yaml`
* Nginx deployment: `kubectl create -f kubernetes/nginx-deployment.yaml`
* Nginx nodeport (for Ingress usage): `kubectl create -f kubernetes/nginx-nodeport.yaml`
* Run migrations for the database: `kubectl create -f kubernetes/php-migrations-job.yaml`
* And finally application ingress to be able to access the app from the internet: `kubectl create -f kubernetes/app-ingress.yaml`

## Application usage
Then access the app from the internet using the ingress IP address:
```bash
✗ kubectl get ingresses
NAME                HOSTS   ADDRESS       PORTS   AGE
k8s-ingress-entry   *       34.98.87.89   80      43h
```

Finally access it using curl for example:

```bash
curl -X GET \
  'http://34.98.87.89/goods' \
  -H 'Cache-Control: no-cache' \
  -H 'Postman-Token: 7dcaa9a2-89d0-4c5a-b3f0-f540288c9a27'
```

Populate 40 random goods in the DB:
```bash
curl -X PUT \
  'http://34.98.87.89/goods/create/40' \
  -H 'Cache-Control: no-cache' \
  -H 'Postman-Token: a38c3d1d-d1af-4890-8fb4-8c8f0c10417e'
```

### Postman collection
[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/abe60f37d86393256e88)

