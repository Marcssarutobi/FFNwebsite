<template>
  <div class="error-page">

    <!-- Main Wrapper -->
        <div class="main-wrapper">
			
			<div class="error-box">
				<h1>403</h1>
				<h3 class="h2 mb-3"><i class="fas fa-exclamation-circle"></i> Oops! Access denied!</h3>
				<p class="h4 font-weight-normal">You do not have permission to access this page.</p>
				<RouterLink to="/admins" class="btn btn-primary">Back to Home</RouterLink>
			</div>
		
        </div>
		<!-- /Main Wrapper -->

  </div>
</template>

<script>
export default {

}
</script>

<style>
.error-page{
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e1e1e1;
}
.error-page .main-wrapper .error-box{
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    
}
</style>