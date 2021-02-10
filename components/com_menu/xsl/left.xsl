<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" />


	<xsl:template match='menu'>
	<xsl:apply-templates select='node' />
	</xsl:template>

	<xsl:template match='node'>

		<xsl:if test="not(@hide)">

			<xsl:if test="@icon!=''">
				<xsl:variable name="link">
					<xsl:value-of select="@icon" />
				</xsl:variable>
			</xsl:if>


			<xsl:variable name="link-style">
				<xsl:choose>
					<xsl:when test="@icon-style!=''">
						<xsl:value-of select="@icon-style" />
					</xsl:when>
					<xsl:otherwise>
						fas
					</xsl:otherwise>
				</xsl:choose>
			</xsl:variable>


			<xsl:variable name="link">
				<xsl:choose>
					<xsl:when test="@icon!=''">
						<xsl:value-of select="@icon" />
					</xsl:when>
				</xsl:choose>
			</xsl:variable>

			<xsl:variable name="link-color">
				<xsl:choose>
					<xsl:when test="@icon-color!=''">
						<xsl:value-of select="@icon-color" />
					</xsl:when>
					<xsl:otherwise>
						white
					</xsl:otherwise>
				</xsl:choose>
			</xsl:variable>

			<li>
				<xsl:if test="@id=$id">
					<xsl:attribute name='class'>active</xsl:attribute>
				</xsl:if>
				<a>

					<xsl:attribute name='href'>
							<xsl:value-of select="@url" />
						</xsl:attribute>
					<i class="{$link-style} fa-{$link} fa-fw text-{$link-color}"></i>

					<xsl:choose>
						<xsl:when test="@html!=''">
							<xsl:variable name="elemName">
								<xsl:value-of select="@html" />
							</xsl:variable>
							<xsl:element name="{$elemName}">
								<xsl:value-of select="label" />
							</xsl:element>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="label" />
						</xsl:otherwise>
					</xsl:choose>

					<xsl:if test="@other!='0' and @other!=''">
						<span class="pull-right-container">
							<xsl:variable name="bg-color">
								<xsl:value-of select="@bg-color" />
							</xsl:variable>
							<xsl:variable name="other-title">
								<xsl:value-of select="@other-title" />
							</xsl:variable>
							<small class="label {$bg-color} pull-right"
								title="{$other-title}">
								<xsl:value-of select="@other" />
							</small>
						</span>
					</xsl:if>
					<xsl:if test="@current!='0' and @current!=''">
						<span class="pull-right-container">
							<small class="label pull-right">
								<span class="fas fa-arrow"></span>
							</small>
						</span>
					</xsl:if>
				</a>

				<xsl:if test="descendant-or-self::node[@id=$id]">
					<ul class='list-unstyled'>
						<xsl:apply-templates select='node' />
					</ul>
				</xsl:if>

			</li>

		</xsl:if>
	</xsl:template>

</xsl:stylesheet>