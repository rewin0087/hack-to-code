private class FacebookPost extends AsyncTask<Void, Void, Void> {

        @Override
        protected Void doInBackground(Void... strings) {
            Bundle params = new Bundle();

            Bitmap bit = BitmapFactory.decodeResource(getResources(), R.drawable.day_background_landscape_);

            byte[] data = null;

            //Bitmap bi = BitmapFactory.decodeFile("/sdcard/viewitems.png");
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            bit.compress(Bitmap.CompressFormat.JPEG, 100, baos);
            data = baos.toByteArray();

            params.putString("access_token", token);
            params.putString("message", "test");
            //params.putString("method", "photos.upload");
            params.putByteArray("picture", data);

            Request request = new Request(
                    Session.getActiveSession(),
                    "me/photos",
                    params,
                    HttpMethod.POST
            );

            Response response = request.executeAndWait();

            if(response.getError() != null) {
                Log.d("ERROR POST",response.getError().toString());
            } else {
                Log.d("EXECUTED POST", " RESPONSE - " + response);
            }

            return null;
        }

        protected void shareDialog() {
                FacebookDialog shareDialog = new FacebookDialog.ShareDialogBuilder(this)
                .setPicture("http://mintywhite.com/wp-content/uploads/2012/10/fond-ecran-wallpaper-image-arriere-plan-hd-29-HD.jpg")
                .build();
                uiHelper.trackPendingDialogCall(shareDialog.present());
        
                // make request to the /me API
                Request.newMeRequest(session, new Request.GraphUserCallback() {
        
                    // callback after Graph API response with user object
                    @Override
                    public void onCompleted(GraphUser user, Response response) {
        
                        Toast.makeText(getApplicationContext(), " Last Name " + user.getLastName(), Toast.LENGTH_LONG).show();
        
                    }
                }).executeAsync();
        }
    };
