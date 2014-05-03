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


    };
