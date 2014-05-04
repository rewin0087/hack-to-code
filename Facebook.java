package com.rnodes.snooozr;


import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.graphics.Bitmap;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Toast;

import com.facebook.HttpMethod;
import com.facebook.Request;
import com.facebook.Response;
import com.facebook.Session;
import com.facebook.SessionState;

import java.io.ByteArrayOutputStream;
import java.util.Arrays;
import java.util.List;

public class Facebook {

    /*
    * Context of the current activity
    *
    **/
    public Context context;

    /*
    * Main activity class of the current activity
    *
    * */
    public Activity activity;

    /*
    * Facebook token to be filled by the facebook request api for access
    *
    * */
    public String token;

    /*
    * List of Publish Permission to be added into the current permissions
    *
    * */
    public static final List<String> PERMISSIONS = Arrays.asList("publish_actions", "publish_stream");

    /*
    * Current Session from the facebook app in the phone
    *
    * */
    public Session current_session;

    /*
    * Image to be Upload
    *
    * */
    public Bitmap bitmap;

    /*
    * Text message to be the title of the post
    *
    * */
    public String message;

    /*
    * Text Description to be the description of a link to be post
    *
    * */
    public String description;

    /*
    * Text caption to be the caption of a link to be post
    *
    * */
    public String caption;

    /*
    * Text Url | valid http url | to be the link to be visit for the link
    *
    * */
    public String url_link;

    /*
    * Text Url for picture to be the interface of the link to be post
    *
    * */
    public String picture_ul;

    /*
    * Initialize params for http values holder
    *
    * */
    public final Bundle params = new Bundle();

    /*
    * Response object for http request
    *
    * */
    public Response response;

    /*
    * Progress Loader
    *
    * */
    protected ProgressDialog progressDialog;

    /*
    * Constructor
    *
    * */
    public Facebook(Context context, Activity activity) {
        this.context = context;
        this.activity = activity;
    }

    /*
    * Setting message to be use for posting as title of the post
    *
    * return self Object
    * */
    public Facebook setMessage(String message) {
        this.message = message;

        return this;
    }

    /*
    * Setting description to be use for posting as description of the link to be post
    *
    * return self Object
    * */
    public Facebook setDescription(String description) {
        this.description = description;

        return this;
    }

    /*
    * Setting caption to be use for posting as caption of the link to be post
    *
    * return self Object
    * */
    public Facebook setCaption(String caption) {
        this.caption = caption;

        return this;
    }

    /*
    * Setting url link to be use for posting as url link of the link to be post
    *
    * return self Object
    * */
    public Facebook setUrlLink(String url_link) {
        this.url_link = url_link;

        return this;
    }

    /*
    * Setting url picture to be use for posting as url picture of the link to be post
    *
    * return self Object
    * */
    public Facebook setPictureUrl(String picture_ul) {
        this.picture_ul = picture_ul;

        return this;
    }

    /*
    * Setting manually the facebook token
    *
    * return self Object
    * */
    public Facebook setToken(String token) {
        this.token = token;

        return this;
    }

    /*
    * Run Facebook Authentication for as to have access from the user for us to create request for facebook
    *
    * return self Object
    * */
    public Facebook Auth() {
        // start Facebook Login
        Session.openActiveSession(activity, true, new Session.StatusCallback() {

            // callback when session changes state
            @Override
            public void call(Session session, SessionState state, Exception exception) {

                // set session to object
                current_session = session;
                // set access token to string property
                token = session.getAccessToken();

                if(session.isOpened()) {
                    // set Publishing
                    setPublishPermissions(session);
                }

                Log.d("SESSION OPENED", "SESSION - " +session.isOpened());
                Log.d("SESSION STATE", "STATE - " + state.isOpened());
                Log.d("EXCEPTION SESSION", exception + "");

            }
        });


        return this;
    }

    /*
    * Setting Session manualy
    *
    * return self Object
    * */
    public Facebook setSession(Session session) {
        this.current_session = session;

        return this;
    }

    /*
    * Setting Publish Permissions
    *
    * */
    public void setPublishPermissions(Session session) {
        // get current permissions
        List<String> permissions = session.getPermissions();
        if (!permissions.containsAll(PERMISSIONS)) {
            // add new permisions from PERMISSIONS
            Session.NewPermissionsRequest newPermissionsRequest = new Session
                    .NewPermissionsRequest(activity, PERMISSIONS);
            // request publish permission
            session.requestNewPublishPermissions(newPermissionsRequest);

            Toast.makeText(
                    activity,
                    "User has been Authenticated and Authorized the app",
                        30000)
                    .show();

            Toast.makeText(
                    activity,
                    "Please try again to send a post to facebook",
                    Toast.LENGTH_LONG)
                    .show();
            return;
        }
    }

    /*
    * Check if session is opened
    *
    * return boolean
    * */
    public boolean isSessionOpened() {
        return current_session.isOpened();
    }

    /*
    * Post Image
    *
    * param bitmap Image
    *
    * */
    public void postImage(Bitmap bitmap) {
        this.bitmap = bitmap;

        if(current_session != null && isSessionOpened()) {
            // show progress dialog loader
            progressDialog = ProgressDialog.show(activity, "Loading...",	"Uploading Image", true);
            progressDialog.setCancelable(false);

            byte[] data = null;

            // get data image to array byte
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            bitmap.compress(Bitmap.CompressFormat.JPEG, 100, baos);
            data = baos.toByteArray();

            // set access token serve as the authorization for as to do valid actions
            params.putString("access_token", token);
            // set message serve as the title of the post
            params.putString("message", message);
            // set picture to be post serve as the main post image
            params.putByteArray("picture", data);

            // Run Image Post
            _PostImage postImage = new _PostImage();
            postImage.execute();
        } else {
            Toast.makeText(context, "Failed to Authenticate", Toast.LENGTH_SHORT).show();
        }
    }

    /*
    * Post Link
    *
    * */
    public void postLink() {

        if(current_session != null && isSessionOpened()) {
            // show progress dialog loader
            progressDialog = ProgressDialog.show(activity, "Loading...",	"Posting Link", true);
            progressDialog.setCancelable(false);
            // set access token serve as the authorization for as to do valid actions
            params.putString("access_token", token);
            // set message serve as the title of the post
            if(message != null) {
                params.putString("name", message);
            }
            // set description serve as the description of the link the text below the image
            if(description != null) {
                params.putString("description", description);
            }
            // set picture url serve as the image representation of the post
            if(picture_ul != null) {
                params.putString("picture", picture_ul);
            }
            // set url link serve as the link to be visit | connect to the real data
            if(url_link != null) {
                params.putString("link", url_link);
            }
            // Run Link Post
            _PostLink postLink = new _PostLink();
            postLink.execute();
        } else {
            Toast.makeText(context, "Failed to Authenticate", Toast.LENGTH_SHORT).show();
        }
    }

    /*
    * Post Status
    *
    * */
    public void postStatus() {

        if(current_session != null) {
            // show progress dialog loader
            progressDialog = ProgressDialog.show(activity, "Loading...", "Posting Status", true);
            progressDialog.setCancelable(false);
            // set access token serve as the authorization for as to do valid actions
            params.putString("access_token", token);
            // set message serve as the title of the post
            params.putString("message", message);
            // Run Status Post
            _PostStatus postStatus = new _PostStatus();
            postStatus.execute();
        } else {
            Toast.makeText(context, "Failed to Authenticate", Toast.LENGTH_SHORT).show();
        }

    }

    /*
    * Http Request for posting Image
    *
    * required property to be fill
    *   token : filled by facebook authentication
    *   message : supplied by setMessage
    *   picture : passed by postImage
    *
    * */
    private class _PostImage extends AsyncTask<Void, Void, Void>{

        @Override
        protected Void doInBackground(Void... voids) {

            // send request now to upload photos
            Request request = new Request(
                    Session.getActiveSession(),
                    "me/photos",
                    params,
                    HttpMethod.POST
            );

            // get response from request
            response = request.executeAndWait();

            return null;
        }

        @Override
        protected void onPostExecute(Void result) {
            _errorCode("image");
        }
    };

    /*
    * Http Request for posting Link
    *
    * required property to be fill
    *   token : filled by facebook authentication
    *   name : supplied by setMessage
    *   picture_url : supplied by setPictureUrl
    *   description : supplied by setDescription
    *   url_link : supplied by setUrlLink
    *
    * */
    private class _PostLink extends AsyncTask<Void, Void, Void>{

        @Override
        protected Void doInBackground(Void... voids) {

            // send request
            Request request = new Request(
                    Session.getActiveSession(),
                    "me/feed",
                    params,
                    HttpMethod.POST
            );

            // get response from the request
            response = request.executeAndWait();

            return null;
        }

        @Override
        protected void onPostExecute(Void result) {
            _errorCode("link");
        }
    };

    /*
    * Http Request for posting Status
    *
    * required property to be fill
    *   token : filled by facebook authentication
    *   message : supplied by setMessage
    *
    * */
    private class _PostStatus extends AsyncTask<Void, Void, Void>{

        @Override
        protected Void doInBackground(Void... voids) {

            // send request
            Request request = new Request(
                    Session.getActiveSession(),
                    "me/feed",
                    params,
                    HttpMethod.POST
            );
            // get response from the request
            response = request.executeAndWait();

            return null;
        }

        @Override
        protected void onPostExecute(Void result) {
            _errorCode("status");
        }
    };


    /*
    * Run Error Code Detection after receiving the status of the request to facebook
    *
    * */
    protected void _errorCode(String postType) {
        // close progress dialog loader
        progressDialog.dismiss();

        // successful post
        if(response.getError() == null) {
            Toast.makeText(activity, "Successfully Posted", Toast.LENGTH_LONG).show();
            Log.d("EXECUTED POST", " RESPONSE - " + response);
        }

        // Authentication error required
        else if(response.getError() != null && response.getError().getErrorCode() == -1) {
            Log.d("ERROR POST", response.getError().toString());
            Toast.makeText(activity, "Need Authentication, Please wait...", Toast.LENGTH_LONG).show();
        }

        // Reauthentication required due to access token error
        else if(response.getError() != null && response.getError().getErrorCode() == 2500) {
            Log.d("ERROR POST", response.getError().toString());
            //Toast.makeText(activity, "Need Reauthentication, Problem with Access Token, Please Wait...", Toast.LENGTH_LONG).show();
            Auth().reSendPost(postType);
        } else if(response.getError() != null && response.getError().getErrorCode() == 190) {
            Log.d("ERROR POST", response.getError().toString());
            Toast.makeText(activity, "Authenticating...", Toast.LENGTH_LONG).show();
            Auth();
        }

        // duplicate post
        else if(response.getError() != null && response.getError().getErrorCode() == 506) {
            Log.d("ERROR POST", response.getError().toString());
            Toast.makeText(activity, "Post Already Shared", Toast.LENGTH_LONG).show();
            Auth();
        }

        // unhandled error,
        else {
            Log.d("ERROR POST", response.getError().toString());
            Toast.makeText(activity, "Failed to Post", Toast.LENGTH_LONG).show();
        }
    }

    /*
    * Fallback resend post request
    *
    * return self Object
    * */
    public Facebook reSendPost(String postType) {

        // repost link
        if(postType.matches("link")) {
            postLink();
        }

        // repost image
        else if(postType.matches("image")) {
            postImage(bitmap);
        }

        // repost status
        else if(postType.matches("status")) {
            postStatus();
        }

        return this;
    }
 }
